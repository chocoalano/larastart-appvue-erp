<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>A simple, clean, and responsive HTML invoice template</title>

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
		<h1>INVOICE PEMBELIAN</h1>
		No. Transaksi : {{ $data->no_transaksi }}<br /><br /><br />

		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="storage/assets/Group 89.png" alt="Company logo" style="width: 100%; max-width: 300px; margin-left:-20px" />
								</td>

								<td>
									Invoice #: {{ $data->no_transaksi }}<br />
									Tanggal: {{ date('d F Y', strtotime(date('Y-m-d'))) }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Seaweed Superapps.<br />
									12345 Sunny Road<br />
									Sunnyville, TX 12345
								</td>

								<td>
									{{ $data['suplayer']->nama }}.<br />
									{{ $data['suplayer']->alamat }}<br />
									{{ $data['suplayer']->no_hp }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Metode Pembayaran</td>

					<td>Cash #</td>
				</tr>

				<tr class="details">
					<td>Cash</td>

					<td>Rp. {{ number_format($data->grand_total) }}</td>
				</tr>

				<tr class="heading">
					<td>Item</td>
					<td>Jumlah</td>
				</tr>
				<tr class="item">
					<td>
                        <strong>{{ $data['komoditi']->jenis }}</strong>,<br>
                         tipe <strong>{{ $data['komoditi']->tipe }}</strong>,<br>
                         qty <strong>{{ $data->qty }}</strong>,<br>
                         harga persatuan <strong>Rp. {{ number_format($data->harga) }}</strong><br>
                    </td>
					<td>Rp. {{ number_format($data->jumlah) }}</td>
				</tr>

				<tr class="total">
					<td></td>
					<td>Subtotal: Rp. {{ number_format($data->subtotal) }}</td>
				</tr>
				<tr class="total">
					<td></td>
					<td>Diskon: {{ $data->diskon }}%</td>
				</tr>
				<tr class="total">
					<td></td>
					<td>Ppn: {{ number_format($data->ppn) }}%</td>
				</tr>
				<tr class="total">
					<td></td>
					<td>Grand Total: Rp. {{ number_format($data->grand_total) }}</td>
				</tr>
			</table>
		</div>
	</body>
</html>