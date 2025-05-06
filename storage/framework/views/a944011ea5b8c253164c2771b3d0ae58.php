<!DOCTYPE html>
<html lang="en">
<head>
    <title>Study Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>Study Summary</h2>
    <div class="container">
        <h4>Gene Data</h4>
        <div id="geneDataContainer">
            <?php echo urldecode(request()->query('geneData', 'No gene data available.')); ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/resources/views/study-summary.blade.php ENDPATH**/ ?>