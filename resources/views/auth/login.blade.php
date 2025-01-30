<x-guest-layout>
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="w-full p-2 border rounded">
            </div>
            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="w-full p-2 border rounded">
            </div>
            <!-- Remember Me -->
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2"> Remember Me
                </label>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-blue-500">Don’t have an account? Register</a>
        </div>
    </div>
</x-guest-layout>