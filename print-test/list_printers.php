<?php
// Function to get the list of printers
function getPrinters() {
    // Run the command to get printers
    $output = [];
    exec('wmic printer get name', $output);

    // Remove the first element which is the column header
    array_shift($output);

    // Remove empty elements (if any)
    $output = array_filter($output);

    // Trim the output to remove any extra whitespace
    $output = array_map('trim', $output);

    return $output;
}

// Get the list of printers
$printers = getPrinters();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Printers</title>
</head>
<body>
    <h1>Available Printers</h1>
    <?php if (!empty($printers)): ?>
        <ul>
            <?php foreach ($printers as $printer): ?>
                <li><?php echo htmlspecialchars($printer); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No printers found.</p>
    <?php endif; ?>
</body>
</html>
