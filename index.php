<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            background-image: url('https://images.pexels.com/photos/4087271/pexels-photo-4087271.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh; /* Ensure full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            height: 80%;
            background: rgba(255, 255, 255, 0.9); /* Add a background color with transparency */
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .left-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
            background-color: #f7f7f7;
        }

        .left-side h1 {
            font-size: 4rem;
            margin: 0;
            font-weight: 700;
            color: #000;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .left-side p {
            font-size: 1.5rem;
            margin-top: 15px;
            margin-bottom: 25px;
            color: #555;
            display: flex;
            flex-wrap: wrap;
        }

        .left-side p span {
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
            margin-right: 0.25rem; /* Add a margin to ensure space between words */
        }

        .left-side p:nth-child(2) span {
            animation-delay: calc(var(--i) * 0.1s);
        }

        .left-side p:nth-child(3) span {
            animation-delay: calc(var(--i) * 0.1s);
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .right-side {
            flex: 1;
            background: url('https://images.pexels.com/photos/4087271/pexels-photo-4087271.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .right-side img {
            border: 5px solid #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <h1>PrintEase</h1>
            <p>
                <?php 
                $words = explode(' ', 'Empowering printing, with just a scan');
                foreach ($words as $index => $word) {
                    echo "<span style='--i: $index;'>$word</span>";
                }
                ?>
            </p>
            <p>
                <?php 
                $words = explode(' ', 'Scan this QR Code for easy printing');
                foreach ($words as $index => $word) {
                    echo "<span style='--i: $index;'>$word</span>";
                }
                ?>
            </p>
        </div>
        <div class="right-side">
            <?php
                function getLocalIpAddresses() {
                    $output = shell_exec('ipconfig');
                    $lines = explode("\n", $output);
                    $ips = [];

                    foreach ($lines as $line) {
                        if (strpos($line, 'IPv4 Address') !== false || strpos($line, 'IPv4-Adresse') !== false) {
                            $parts = explode(':', $line);
                            if (count($parts) > 1) {
                                $ips[] = trim($parts[1]);
                            }
                        }
                    }

                    return $ips;
                }
                $localIps = getLocalIpAddresses();
                print_r($localIps);
                $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode("https://" . $localIps[2] . '/hackathon/account/login/');
                ?>
                <div>
                    <img src="<?php echo "data:image/png;base64," . base64_encode(file_get_contents($qr_url)); ?>" alt="QR Code">
                </div>
        </div>
    </div>
</body>
</html>
