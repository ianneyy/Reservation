<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uniforms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/size_guide.css') }}">
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/help.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/view_details.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/message.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="p-4">
        <div class="logo-title">
            <img src="../img/lspu_logo.png" alt="">
            <h3>Business Affair Office</h3>
        </div>
        <ul>

            <li><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="none" stroke="black" stroke-linecap="round" stroke-width="2" d="m21 21l-3.5-3.5M17 10a7 7 0 1 1-14 0a7 7 0 0 1 14 0Z" />
                </svg></li>
            <li>

                <div id="cart">
                    <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4a2 2 0 0 0 0-4m8 0a2 2 0 1 0 0 4a2 2 0 0 0 0-4m-8.5-3h9.25L19 7H7.312" />
                    </svg>
                </div>

            </li>

            <li>
                @if(auth('student')->check())
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$name}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form method="POST" action="{{ route('student.logout') }}">
                            @csrf
                            <button class="dropdown-item">Logout</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('student.user-login') }}" class="btn">Login</a>
                @endif
            </li>

        </ul>
    </nav>
    <form action="{{ url('continue-fill-up')}}" method="post">
        @csrf
        <div class="cart-popup">
            <div class="cart-items">
                <h5 class="cart-head mb-2 mt-2">Cart</h5>
                <hr>

                @forelse($cartData as $cart)

                <div class="item-container mb-3">
                    <div class="item-card">

                        <div class="cbx-img">
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="morning{{$cart->id}}" type="checkbox" data-price="{{$cart->price}}" data-name="{{$cart->name}}" data-id="{{$cart->id}}" data-image="{{$cart->image_url}}" data-variation="{{$cart->variation_type}}" data-size="{{$cart->size}}" />
                                <label class="cbx" for="morning{{$cart->id}}"><span>
                                        <svg width="12px" height="10px">
                                            <use xlink:href="#check-4"></use>
                                        </svg></span>
                                </label>
                                <svg class="inline-svg">
                                    <symbol id="check-4" viewbox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>
                            <div class="cart-img">
                                <img src="../{{$cart->image_url}}" alt="">
                            </div>
                        </div>
                        <div class="prdct-info">
                            <h5>{{$cart->name}}</h5>
                            <p>{{$cart->size}} - {{$cart->variation_type}}</p>
                            <p class="p">P{{$cart->price}}</p>
                        </div>
                        <div class="qty-edit">
                            <div class="edit">
                                <p class="edit-btn">Edit</p>
                            </div>
                            <div class="qty">
                                <span class="minus1">-</span>
                                <!-- <span class="num" name="qty">01</span> -->
                                <input type="number" id="qty{{$cart->id}}" name="qty" class="num1" value="{{$cart->qty}}">
                                <span class="plus1">+</span>

                            </div>
                        </div>
                    </div>

                    <div class="delete-btn">
                        <a href="{{url('delete-cart/' . $cart->id)}}" style="text-decoration:none; display:flex; flex-direction: column; align-items:center;">
                            <i class="fa-solid fa-trash"></i>
                            <p>Delete</p>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="width: 400px; display:flex; flex-direction:column; align-items: center; justify-content: center;">
                    <img src="../img/empty_cart.svg" alt="" style="height: 100px;">
                    <p style="color: #555;">Your cart is empty.</p>
                </div>
                @endforelse

            </div>


            <div class="cart-bottom">

                <hr class="hr-bottom">
                <div class="amount">
                    <p>Total Amount</p>
                    <h5 id="totalAmount"></h5>
                    <input type="hidden" name="total_price" id="total_price" value="">
                    <input type="hidden" name="selected_items" id="selected_items" value="">
                </div>
                <div class="cart-btn">
                    <a href="" class="btn btn-link text-muted">
                        <i class="mdi mdi-arrow-left me-1"></i> Go Back </a>
                    <button class="cart-rsv" name="action" value="reserve_now">RESERVE NOW</button>
                </div>
            </div>

        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    @yield('content')


    <script>
        // function changeCartBorderColor() {
        //     const cart = document.getElementById('cart');

        //     cart.classList.toggle('border-bottom-active');
        // }
        document.getElementById("cart").addEventListener("click", function() {
            var cartPopup = document.querySelector(".cart-popup");
            cartPopup.classList.toggle("show");
            const cart = document.getElementById('cart');

            cart.classList.toggle('border-bottom-active');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const plus = document.querySelector(".plus1"),
                minus = document.querySelector(".minus1"),
                num = document.querySelector(".num1");
            let a = 1;
            plus.addEventListener("click", () => {
                a++;
                a = a < 10 ? "0" + a : a;
                num.value = a;
            });

            minus.addEventListener("click", () => {
                if (a > 1) {
                    a--;
                    a = a < 10 ? "0" + a : a;
                    num.value = a;
                }
            });


            const editButtons = document.querySelectorAll('.edit-btn'); // Select all "Edit" buttons

            // Loop through each button and add a click event listener
            editButtons.forEach((btn, index) => {
                btn.addEventListener('click', function() {
                    const container = this.closest('.item-container');
                    container.classList.toggle('edit-mode');
                });
            });


            // Optionally, you can add an event to close the popup when clicking outside of it
            window.addEventListener("click", function(e) {
                if (!document.querySelector(".cart-popup").contains(e.target) && !document.getElementById("cart").contains(e.target)) {
                    const cart = document.getElementById('cart');

                    // Only remove the border if it's currently applied
                    if (cart.classList.contains('border-bottom-active')) {
                        cart.classList.remove('border-bottom-active');
                    }
                    document.querySelector(".cart-popup").classList.remove("show");
                }
            });
            document.querySelectorAll('.inp-cbx').forEach(checkbox => {
                checkbox.addEventListener('change', updateTotalAmount);
            });


            function updateTotalAmount() {
                let totalAmount = 0;
                let selectedItems = [];

                // Loop through all checkboxes and add the price of the selected ones
                document.querySelectorAll('.inp-cbx:checked').forEach(checkbox => {

                    const price = parseFloat(checkbox.getAttribute('data-price')); // Get the price
                    const id = checkbox.getAttribute('data-id'); // Get the item ID


                    // Fetch the correct quantity input for each item
                    const qtyElement = document.querySelector(`#qty${id}`);

                    const qty = qtyElement ? parseInt(qtyElement.value) : 1; // Get quantity, default to 1 if not found
                    const subTotal = price * qty;
                    totalAmount += price * qty;


                    const item = {
                        id: id,
                        name: checkbox.getAttribute('data-name'),
                        price: price,
                        subTotal: subTotal,
                        image_url: checkbox.getAttribute('data-image'),
                        variation_type: checkbox.getAttribute('data-variation'),
                        size: checkbox.getAttribute('data-size'),
                        qty: qty
                    };
                    selectedItems.push(item);
                });

                console.log("Total Amount:", totalAmount);
                // Update the total amount on the page
                document.getElementById('totalAmount').textContent = 'P ' + totalAmount.toFixed(2);
                document.getElementById('total_price').value = totalAmount.toFixed(2);

                document.getElementById('selected_items').value = JSON.stringify(selectedItems);
            }

        });
    </script>
</body>


</html>