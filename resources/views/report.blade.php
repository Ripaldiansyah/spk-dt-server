<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        .report-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            padding-bottom: 100px; /* Space for footer */
            box-sizing: border-box;
        }
        .section {
            margin-bottom: 20px;
        }
        .input-table, .recommended-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .input-table th, .recommended-table th {
            background-color: #f4f4f4;
            padding: 8px;
            text-align: left;
        }
        .input-table td, .recommended-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .input-table tr:nth-child(even), .recommended-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .recommended-product {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .recommended-product img {
            width: 80px;
            height: 80px;
            margin-right: 10px;
        }
        .product-details {
            max-width: 700px;
        }

        /* Footer styles */
        .footer {
            position: absolute;
            bottom: 20px;
            right: 20px;
            text-align: right;
            width: 100%;
            font-size: 12px;
        }
        
        .footer .date {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .footer .signature {
            margin-top: 70px; /* Add space before the signature */
            font-weight: bold;
            line-height: 1.5; /* Increase space between name and position */
            
        }

        /* Add a horizontal line for separation */
        .footer hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 20px 0;
        }

    </style>
</head>
<body>

    <div class="report-container">

        <h1>Laporan SPK Produk Rekomendasi</h1>
        
        <div class="section">
            <p><strong>Prediction: </strong>{{ $prediction['prediction'] }}</p>
        </div>

        <table class="input-table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Harga</td>
                    <td>{{ $prediction['input']['harga'] }}</td>
                </tr>
                <tr>
                    <td>Garansi</td>
                    <td>{{ $prediction['input']['garansi'] }}</td>
                </tr>
                <tr>
                    <td>Fitur</td>
                    <td>{{ $prediction['input']['fitur'] }}</td>
                </tr>
                <tr>
                    <td>Kualitas</td>
                    <td>{{ $prediction['input']['kualitas'] }}</td>
                </tr>
            </tbody>
        </table>

      <div class="section">
    <h2>Daftar Produk</h2>
    @foreach ($prediction['recommended_products'] as $product)
        <div class="recommended-product" style="margin-bottom: 10px;"> <!-- Menambahkan margin bottom -->
            <div style="display: flex; align-items: center; margin-bottom: -20px;"> <!-- Mengurangi jarak antar Product Name dan atribut -->
                <p><strong>{{ $loop->iteration }}.</strong> <strong>Product Name:</strong> {{ $product['product_name'] }}</p>
            </div>
            <div style="display: flex; flex-direction: column; margin-left: 18px;">
                <p style="margin-bottom: 2px;"><strong>Harga:</strong> {{ number_format($product['harga'], 0, ',', '.') }}</p>
                <p style="margin-bottom: 2px;"><strong>Garansi:</strong> {{ $product['garansi'] }}</p>
                <p style="margin-bottom: 2px;"><strong>Fitur:</strong> {{ $product['fitur'] }}</p>
                <p style="margin-bottom: 2px;"><strong>Kualitas:</strong> {{ $product['kualitas'] }}</p>
            </div>
            <hr> <!-- Garis pemisah antar produk -->
        </div>
    @endforeach
</div>




    </div>

    <!-- Footer -->
    <div class="footer">
        <!-- Tanggal -->
        <div class="date">
            <p>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>

        <!-- Garis Pemisah -->
        

        <!-- Signature -->
        <div class="signature">
    
            <p>Raka Ardiansyah</p>
            <p>PIC</p>
        </div>
    </div>

</body>
</html>
