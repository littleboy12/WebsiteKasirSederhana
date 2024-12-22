<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
  
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            position: fixed;
            width: 100%;
            background-color: #343a40;
            color: white;
            padding: 1rem;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a {
            color: white;
            text-decoration: none;
            margin-left: 1rem;
        }
        header a:hover {
            text-decoration: underline;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 1rem;
            margin-top: 4rem;
            position: fixed;
            transition: transform 0.3s ease-in-out;
            transform: translateX(0);
        }
        .sidebar.closed {
            transform: translateX(-100%);
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            margin: 0.5rem 0;
        }
        .sidebar a:hover {
            color: white;
        }
        .content {
            margin-left: 100px;
            margin-top: 5rem;
            flex: 1;
            padding: 2rem;
            transition: margin-left 0.3s ease-in-out;
        }
        .content.expanded {
            margin-left: 0;
        }
        .toggle-btn {
            /* position: fixed; */
            top: 1rem;
            left: 1rem;
            z-index: 1000;
            background-color: #343a40;
            border: solid white 5px;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <!-- <h1 class="h3">Professional Checkout</h1> -->
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <nav>
        <a href="#">Home</a>
        <a href="#">Contact</a>
    </nav>
</header>



<div class="sidebar" id="sidebar">

    <h5 class="text-white">Menu</h5>
    <a href="../views/view_dashboard.php">Dashboard</a>
    <a href="../views/view_kasir.php">Kasir</a>
    <a href="../views/view_barang.php">Barang</a>
    <a href="../views/view_penjualan.php">Penjualan</a>
    <a href="../public/logout.php" class="text-danger">Logout</a>
</div>

<div class="content" id="content">