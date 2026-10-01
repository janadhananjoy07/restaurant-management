<!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Registration | BenStoke</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    .register-card {
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.7),
            0 0 0 1px rgba(255, 255, 255, 0.03);
    }
</style>

</head> <body class="min-h-screen bg-stone-950 text-stone-100"> <div class="min-h-screen flex">
<!-- LEFT SIDE -->
<div class="hidden lg:flex lg:w-1/2 relative overflow-hidden
            bg-gradient-to-br from-stone-900 via-stone-950 to-black">

    <!-- Decorative Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96
                bg-amber-500/10 rounded-full blur-3xl">
    </div>

    <div class="absolute -bottom-32 -right-32 w-96 h-96
                bg-amber-500/10 rounded-full blur-3xl">
    </div>

    <div class="relative z-10 flex flex-col justify-center
                px-16 xl:px-24">

        <!-- Brand -->
        <div class="flex items-center gap-4 mb-10">

            <div class="w-14 h-14 rounded-2xl bg-amber-500
                        flex items-center justify-center
                        text-stone-950 text-2xl font-black
                        shadow-lg shadow-amber-500/20">
                B
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white">
                    BenStoke
                </h2>

                <p class="text-xs uppercase tracking-[0.25em]
                          text-amber-500 font-semibold">
                    Admin System
                </p>
            </div>

        </div>

        <!-- Main Text -->
        <h1 class="text-5xl xl:text-6xl font-black
                   leading-tight tracking-tight text-white">

            Build your
            <span class="text-amber-500">admin</span>
            workspace.

        </h1>

        <p class="mt-6 max-w-lg text-stone-400 text-lg leading-relaxed">

            Create your administrator account and get complete
            control over your restaurant management system.

        </p>

        <!-- Features -->
        <div class="mt-10 space-y-4">

            <div class="flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg
                            bg-amber-500/10
                            flex items-center justify-center
                            text-amber-500 font-bold">
                    ✓
                </div>

                <span class="text-stone-300">
                    Manage restaurant menu
                </span>

            </div>

            <div class="flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg
                            bg-amber-500/10
                            flex items-center justify-center
                            text-amber-500 font-bold">
                    ✓
                </div>

                <span class="text-stone-300">
                    Monitor orders and bookings
                </span>

            </div>

            <div class="flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg
                            bg-amber-500/10
                            flex items-center justify-center
                            text-amber-500 font-bold">
                    ✓
                </div>

                <span class="text-stone-300">
                    Secure administrator access
                </span>

            </div>

        </div>

    </div>

</div>


<!-- RIGHT SIDE -->
<div class="w-full lg:w-1/2 flex items-center justify-center
            px-6 py-10 bg-stone-950">

    <div class="w-full max-w-md">

        <!-- Mobile Logo -->
        <div class="lg:hidden text-center mb-8">

            <div class="inline-flex w-14 h-14 rounded-2xl
                        bg-amber-500 items-center justify-center
                        text-stone-950 text-2xl font-black">
                B
            </div>

            <h2 class="text-xl font-bold text-white mt-3">
                BenStoke
            </h2>

            <p class="text-xs uppercase tracking-widest
                      text-amber-500 mt-1">
                Admin System
            </p>

        </div>


        <!-- Registration Card -->
        <div class="register-card bg-stone-900 border
                    border-stone-800 rounded-3xl p-8 sm:p-10">

            <!-- Heading -->
            <div class="mb-7">

                <p class="text-amber-500 text-xs font-bold
                          uppercase tracking-widest mb-2">
                    Administrator
                </p>

                <h1 class="text-3xl font-bold text-white">
                    Create account
                </h1>

                <p class="text-stone-400 text-sm mt-2">
                    Register a new administrator account.
                </p>

            </div>


            <!-- Errors -->
            @if($errors->any())

                <div class="mb-6 p-4 rounded-xl
                            bg-red-950/40
                            border border-red-900/60
                            text-red-300 text-sm">

                    <div class="font-semibold mb-2">
                        Please fix the following:
                    </div>

                    <ul class="space-y-1">

                        @foreach($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- REGISTER FORM -->
            <form action="{{ route('admin.register.store') }}"
                  method="POST"
                  class="space-y-5">

                @csrf

                <!-- ROLE: ALWAYS ADMIN -->
                <input type="hidden" name="role" value="admin">


                <!-- Name -->
                <div>

                    <label for="name"
                           class="block text-sm font-semibold
                                  text-stone-300 mb-2">

                        Admin Name

                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        placeholder="Enter your name"

                        class="w-full px-4 py-3.5
                               bg-stone-950
                               border border-stone-700
                               rounded-xl
                               text-white
                               placeholder-stone-600
                               outline-none
                               transition
                               focus:border-amber-500
                               focus:ring-2
                               focus:ring-amber-500/20"
                    >

                </div>


                <!-- Email -->
                <div>

                    <label for="email"
                           class="block text-sm font-semibold
                                  text-stone-300 mb-2">

                        Email Address

                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="admin@example.com"

                        class="w-full px-4 py-3.5
                               bg-stone-950
                               border border-stone-700
                               rounded-xl
                               text-white
                               placeholder-stone-600
                               outline-none
                               transition
                               focus:border-amber-500
                               focus:ring-2
                               focus:ring-amber-500/20"
                    >

                </div>


                <!-- Password -->
                <div>

                    <label for="password"
                           class="block text-sm font-semibold
                                  text-stone-300 mb-2">

                        Password

                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Create a password"

                        class="w-full px-4 py-3.5
                               bg-stone-950
                               border border-stone-700
                               rounded-xl
                               text-white
                               placeholder-stone-600
                               outline-none
                               transition
                               focus:border-amber-500
                               focus:ring-2
                               focus:ring-amber-500/20"
                    >

                </div>


                <!-- Confirm Password -->
                <div>

                    <label for="password_confirmation"
                           class="block text-sm font-semibold
                                  text-stone-300 mb-2">

                        Confirm Password

                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your password"

                        class="w-full px-4 py-3.5
                               bg-stone-950
                               border border-stone-700
                               rounded-xl
                               text-white
                               placeholder-stone-600
                               outline-none
                               transition
                               focus:border-amber-500
                               focus:ring-2
                               focus:ring-amber-500/20"
                    >

                </div>


                <!-- Submit -->
                <button
                    type="submit"

                    class="w-full py-3.5 px-5
                           bg-amber-500
                           hover:bg-amber-400
                           active:bg-amber-600
                           text-stone-950
                           font-bold
                           rounded-xl
                           transition-all
                           duration-200
                           shadow-lg
                           shadow-amber-500/10
                           hover:shadow-amber-500/20">

                    Create Admin Account

                </button>

            </form>


            <!-- Login -->
            <div class="mt-7 pt-6 border-t border-stone-800
                        text-center">

                <p class="text-sm text-stone-500">
                    Already have an admin account?
                </p>

                <a
                    href="{{ route('admin.login') }}"

                    class="inline-block mt-2
                           text-amber-500
                           hover:text-amber-400
                           font-semibold text-sm
                           transition">

                    Login to Admin Panel →

                </a>

            </div>

        </div>


        <!-- Footer -->
        <div class="text-center mt-6">

            <a
                href="/"
                class="text-xs text-stone-600
                       hover:text-stone-400 transition">

                ← Back to website

            </a>

        </div>

    </div>

</div>

</div> </body> </html>