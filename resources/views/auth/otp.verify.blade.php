<x-admin title="Verify OTP">

<div class="card p-4">
    <form action="{{ route('otp.verify.submit', $user->id) }}" method="POST">
        @csrf
        <x-form.input type="text" name="code" label="Enter OTP" required />
        <button class="btn btn-success">Verify</button>
    </form>
</div>

</x-admin>
