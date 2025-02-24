<form action="{{ url('/fawry-payment') }}" method="POST">
    @csrf
    <label>Customer ID:</label>
    <input type="text" name="customer_id" required>
    <label>Amount:</label>
    <input type="number" name="amount" required>
    <button type="submit">Pay with Fawry</button>
</form>
