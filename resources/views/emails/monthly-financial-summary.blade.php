<p>Has gastado {{ $total_expenses }}</p>

<ul>
@foreach ($expense_totals as $row)
    <li>{{ $row['category'] }}: {{ $row['total_amount'] }}</li>
@endforeach
</ul>

<p>Total: {{ $total_expenses }}</p>
