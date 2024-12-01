<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Uniforms;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
class ReserveController extends Controller
{


    // Log current session and user


    public function reserve(Request $request)
    {
        $userId = Auth::guard('student')->id();

        // Fetch the department name
        $variationName = DB::table('product_variations')
            ->where('id', $request->input('department'))
            ->value('variation_type');

        // Fetch the size name
        $sizeName = DB::table('product_variation_sizes')
        ->where('id', $request->input('size'))
        ->value('size');

        // Fetch the student data based on the authenticated user's ID
        $student = DB::table('students')
        ->where('id', $userId)
        ->first();

        if (!$student) {
            Log::warning('Student not found for user_id: ' . $userId);
            return redirect()->route('student.user-login')->with('error', 'Student not found');
        }

        // Proceed if student exists
        $fullName = $student->name;
        $email = $student->email;

        // Calculate the total price
        $totalPrice = $request->input('price') * $request->input('qty');
        $orderId = uniqid('order_');
        // Handle "reserve_now" action
        if ($request->action == 'reserve_now') {
            $query = DB::table('reservation')
            ->insertGetId([
                'user_id' => $userId,
                'order_id' => $orderId,   
                'full_name' => $fullName,
                'email' => $email,
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'image_url' => $request->input('image_url'),
                'variation_type' => $variationName,
                'size' => $sizeName,
                'subTotal' => $totalPrice,
                'qty' => $request->input('qty'),
                'total_price' => $totalPrice
            ]);

            if ($query) {
                return redirect(url('/fill-up-form')); // Redirect to the fill-up form after reservation
            }
        }

        // Handle "add_to_cart" action
        elseif ($request->action == 'add_to_cart') {
            $query = DB::table('cart')
            ->insertGetId([
                'user_id' => $userId,
                'image_url' => $request->input('image_url'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'variation_type' => $variationName,
                'size' => $sizeName,
                'qty' => $request->input('qty'),
                'total_price' => $totalPrice
            ]);

            if ($query) {
                // Ensure you redirect to the cart page or another desired location
                return redirect()->back()->with('success', 'Product added to cart!');
            } else {
                return redirect()->back()->with('error', 'Failed to add to cart.');
            }
        }
    }
    public function sendToFillUpForm(Request $request){
        $userId = Auth::guard('student')->id();

        $student = DB::table('students')
        ->where('id', $userId)
        ->first();

        $fullName = $student->name;
        $email = $student->email;
        $selectedItems = json_decode($request->input('selected_items'), true);
        $totalPrice = $request->input('total_price');
        $uniqueCartId = uniqid('cart_');
        $orderId = uniqid('order_');

        foreach ($selectedItems as $item) {

           

            // Insert each item into the reservation table
            DB::table('reservation')->insert([
                'order_id' => $orderId,
                'user_id' => $userId,
                'full_name' => $fullName,
                'email' => $email,
                'name' => $item['name'],
                'price' => $item['price'],
                'image_url' => $item['image_url'],
                'variation_type' => $item['variation_type'],
                'size' => $item['size'],
                'qty' => $item['qty'],
                'subTotal' => $item['subTotal'],
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('cart')
            ->where('id',$item['id'])
            ->where('user_id', $userId)
            
            ->update([
            'cart_id' => $uniqueCartId, 
            'updated_at' => now()]);
        }
        return redirect(url('/fill-up-form'));
    }


    public function showReserve(){
        $latestId = DB::table('reservation')
        ->orderBy('id', 'desc') 
        ->value('id');

        $orderId = DB::table('reservation')
        ->where('id', $latestId)
        ->value('order_id');

        $count = DB::table('student_reservation')
        ->where('status', 'pending')
        ->count();

        $count = DB::table('student_reservation')
        ->where('status', 'pending')
        ->count();
        // $minDate = ($count > 1) ? now()->addDay()->format('Y-m-d') : now()->format('Y-m-d');

        $threshold = 1;

        $daysToAdd = ceil($count / $threshold);

        $minDate = now()->addDays($daysToAdd);
        Log::info($minDate);

        while (true) {
            // Skip weekends
            if ($minDate->isWeekend()) {
                $minDate->addDay();
                continue;
            }

            // Check the reservation count for this specific date
            $dateCount = DB::table('student_reservation')
            ->whereDate('reservation_date', $minDate->format('Y-m-d')) // Adjust column name if needed
                ->where('status', 'pending')
                ->count();

            // If the count for this day is within the threshold, stop looping
            if ($dateCount < $threshold) {
                break;
            }

            // Otherwise, move to the next day
            $minDate->addDay();
        }
        Log::info($minDate);

        $maxDate = $minDate->copy()->addDays(7);
        while ($maxDate->isWeekend()) {
            $maxDate->subDay(); 
        }
        
        $minDateFormatted = $minDate->format('Y-m-d');
        Log::info($minDateFormatted);
        $maxDateFormatted = $maxDate->format('Y-m-d');



        $getOrderId  = DB::table('reservation')
        ->where('order_id', $orderId) // Filter by order_id
        ->get();
        $userId = Auth::guard('student')->id();

        $getCartId  = DB::table('cart')
        ->where('user_id', $userId)
        ->whereNotNull('cart_id')
        ->get();

        
        $data = DB::table('reservation')
        ->where('id', $latestId)
        ->get();
        return view('pages.fill_up_form',compact('data','minDateFormatted', 'maxDateFormatted', 'getOrderId', 'getCartId'));
    }
    public function continueShopping($id){
        $query =DB::table('reservation')
        ->where('id', $id)
        ->delete();
        
        if($query){
            return redirect(url('/student/uniforms'));
        };
    }
    public function addReserve(Request $request)
    {

        $userId = Auth::guard('student')->id();
      

        $fullName = $request->input('full_name');
        $email = $request->input('email');
        $contactNumber = $request->input('contact_number');
        $totalPrice = $request->input('total_price');
        $reservationDate = $request->input('reservation_date');
        $payMethod = $request->input('pay_method');
        $orderId = $request->input('order_id');

        $orders = $request->input('orders');
        $qrCodeData = route('qrcode.show', $orderId);

        $qrCodePath = 'img/qrcodes/' . $orderId . '.svg';
        $qrCode = QrCode::size(400)->generate($qrCodeData);

        file_put_contents(public_path($qrCodePath), $qrCode);

        $qrCodeId =  DB::table('qr_code')->insertGetId([
            'user_id' => $userId,
            'order_id' => $orderId,
            'qrcode' => $qrCodePath

        ]);
        foreach ($orders as $reservation) {
            $reservationId =  DB::table('student_reservation')->insertGetId([
                'user_id' => $userId,
                'order_id' => $orderId,
                'qrcode_id' => $qrCodeId, 
                'full_name' => $fullName,
                'email' => $email,
                'contact_number' => $contactNumber,
                'name' => $reservation['name'],
                'department' => $reservation['department'],
                'size' => $reservation['size'],
                'qty' => $reservation['qty'],
                'subTotal' => $reservation['subTotal'],
                'total_price' => $totalPrice,
                'reservation_date' => $reservationDate,
                'pay_method' => $payMethod,
                        
            ]);

            // $getVariationId = DB::table('product_variations')
            // ->where('', $reservationId)
            // ->get();


            DB::table('products')
            ->where('name', $reservation['name']) // Match by product name or another unique identifier
            ->decrement('stock', $reservation['qty']);

            // DB::table('product_variation_sizes')
            // ->where('name', $reservation['name']) // Match by product name or another unique identifier
            // ->decrement('stock', $reservation['department']);
          
           
        }
      
        $cartId = $request->input('cart_id');
        if (!empty($cartId)) {
            DB::table('cart')
            ->where('cart_id', $cartId)
            ->orderBy('updated_at', 'asc')
                ->delete();
        } else {
            // Log an error or handle the invalid cart_id case
            Log::error('Cart ID is empty or invalid.');
        }

    
     

        return redirect(url('/student/qrcode'));
    }
    public function show($id)
    {
        // Retrieve reservation details from the database
        $reservation = DB::table('student_reservation')->where('id', $id)->first();

        // Return the reservation details view
        return view('pages.show', compact('reservation'));
    }
  
    
}
