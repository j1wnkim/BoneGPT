<?php $__env->startSection('title', 'Study Summary'); ?>

<?php
    use App\Models\ExperimentalGroup;
?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Gene Summary</h1>
    <div class="container">
        <h4>Gene Data</h4>
        <div id="geneDataContainer">
            <?php
                $rawGeneData = request()->query('geneData', '{}'); // Get raw query parameter
                $decodedGeneData = urldecode($rawGeneData); // Decode URL-encoded string

                // Extract JSON part using regex
                preg_match('/\{.*\}/s', $decodedGeneData, $matches);
                $jsonPart = $matches[0] ?? '{}'; // Default to empty JSON if no match

                $fullData = json_decode($jsonPart, true); // Decode and parse JSON

                // Log debugging output
                if (!$fullData) {
                    \Log::debug('Gene Summary Debugging:', [
                        'rawGeneData' => $rawGeneData,
                        'decodedGeneData' => $decodedGeneData,
                        'jsonPart' => $jsonPart,
                        'jsonError' => json_last_error_msg(),
                    ]);
                }
            ?>

            <?php if($fullData): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $fullData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key); ?></td>
                                <td><?php echo e($value); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No gene data available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/gene-summary.blade.php ENDPATH**/ ?>