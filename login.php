<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | TuiTuit</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="public/css/tuituit.css">
    <!-- <link href="public/css/tailwind.css" rel="stylesheet"> -->
</head>

<body style="background-image: url('public/images/petra.jpg'); background-size: cover; background-position: center;">
    <div class="flex justify-center min-h-screen p-4">
        <div class="flex-initial w-full max-w-3/5 flex justify-center items-center">
            <section>
                <div class="pb-5">
                    <h1 class="font-[Tuit_Tuit_Regular] text-8xl text-green-300">tuit tuit</h1>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h5>Login</h5>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                            Login failed: Invalid username or password
                        </div>
                    <?php endif; ?>
                    <form action="actions/login_action.php" method="POST">
                        <div class="m-2">
                            <label for="fusername">Username:</label>
                            <input type="text" id="fusername" name="username" class="ring-2 ring-black">
                        </div>
                        <div class="m-2">
                            <labe] for="fpassword">Password:</label>
                                <input type="password" id="fpassword" name="password" class="ring-2 ring-black">
                        </div>
                        <button type="submit" class="p-2 rounded-lg"
                            style="background-color: #B45309; color: #FFFFFF;">Login</button>
                    </form>
                    <h5>Don't have an account?</h5>
                    <a href="register.php" class="text-blue-500 underline">Register</a>
                </div>
            </section>

        </div>
    </div>

</body>

</html>