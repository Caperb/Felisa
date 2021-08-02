<h1>Beste klant,</h1>
<p>Deze e-mail wordt automatisch verstuurt om u op de hoogte te brengen dat de bestelling en betaling door het systeem is verwerkt.</p>
<p>Doordat alles handgemaakt is laten wij u weten zodra de bestelling wordt gemaakt, vervolgens krijgt u nog een e-mail zodra de bestelling verstuurt is.</p>
<p>Als er verder nog vragen of opmerkingen zijn horen wij dat graag!</p>
<p>orderID: {{ $orderID }}</p>
<p>Bestelde Producten:</p>
<table>
  <tr>
    <th>ID</th>
    <th>Naam</th>
    <th>Aantal</th>
  </tr>
  @foreach($producten as $product)
  <tr>
    <td>{{ $product->productID }}</td>
    <td>{{ $product->naam }}</td>
    <td>{{ $product->amount }}</td>
  </tr>
  @endforeach
</table>

<br>
<p>Met vriendelijke groet,</p>
<p>Felisa, handmade with love.</p>

<style>
table {
  max-width: 500px;
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
