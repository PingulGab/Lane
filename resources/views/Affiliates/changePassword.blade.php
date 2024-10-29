<form method="POST" action="{{ route('affiliateChangePassword', ['id' => $id, 'name' => $name]) }}">
    @csrf
    <label for="password">New Password:</label>
    <input type="password" name="password" id="password" required>
    @if ($errors->has('password'))
        <div class="error">{{ $errors->first('password') }}</div>
    @endif

    <br>
    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>
    @if ($errors->has('password_confirmation'))
        <div class="error">{{ $errors->first('password_confirmation') }}</div>
    @endif

    <button type="submit">Change Password</button>
</form>
