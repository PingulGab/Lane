<form method="POST" action="{{ url('affiliate/change-password/' . $link) }}">
    @csrf
    <label for="password">New Password:</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <button type="submit">Change Password</button>
</form>