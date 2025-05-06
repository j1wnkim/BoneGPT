<div x-data="{
	
}">
    <?php if($title): ?>
        <h3><?php echo e($title); ?></h3>
    <?php endif; ?>

	<div class="form-group mb-3">
		<label for="" class="form-label">Name of Animal Model </label>
		<input type="text" name="" id="" class="form-control" x-model="animalModelName" placeholder=" ">
	</div>

	<div class="form-group mb-3">
        <label for="" class="form-label">
            
        </label>
        <input type="text" name="<?php echo e($prefix); ?>_investigator_name<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_investigator_name<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-control" x-model="investigatorName" placeholder=" ">
    </div>

    <div class="form-group mb-3">
        <label for="<?php echo e($prefix); ?>_gene_name<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">
            <?php echo e(sprintf($nameLabel, $isSecondLine ? '2' : '')); ?>

        </label>
        <input type="text" name="<?php echo e($prefix); ?>_gene_name<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_gene_name<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-control" x-model="geneName" placeholder=" ">
    </div>

    <div class="form-group mb-3">
        <label for="<?php echo e($prefix); ?>_gene_symbol<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Gene Symbol of Genetically Modified Gene <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
        <input type="text" name="<?php echo e($prefix); ?>_gene_symbol<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_gene_symbol<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-control" x-model="geneSymbol" placeholder=" ">
    </div>

    <?php if($prefix !== 'gm_cond_knockout'): ?>
        <div class="form-group mb-3">
            <label for="<?php echo e($prefix); ?>_modification_type<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Type of Genetic Modification <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
            <select name="<?php echo e($prefix); ?>_modification_type<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_modification_type<?php echo e($isSecondLine ? '_2' : ''); ?>" x-model="modificationType" class="form-select">
                <option value="">Select type...</option>
                <?php $__currentLoopData = $modificationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    <?php endif; ?>

    <div class="form-group mb-3">
        <label for="<?php echo e($prefix); ?>_allele_schema<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Mutant Allele Schema to Follow <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
        <select name="<?php echo e($prefix); ?>_allele_schema<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_allele_schema<?php echo e($isSecondLine ? '_2' : ''); ?>" x-model="alleleSchema" class="form-select">
            <option value="">Select schema...</option>
            <?php $__currentLoopData = $alleleSchemas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <div class="form-group mt-3" x-show="alleleSchema === 'other'">
            <label for="<?php echo e($prefix); ?>_allele_abbreviation<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">
				Mutant Allele Abbreviation/Symbol <?php if($isSecondLine): ?> 2 <?php endif; ?>
				<span class="text-muted">(max 4 characters)</span>
			</label>
            <input 
                type="text" 
                name="<?php echo e($prefix); ?>_allele_abbreviation<?php echo e($isSecondLine ? '_2' : ''); ?>" 
                id="<?php echo e($prefix); ?>_allele_abbreviation<?php echo e($isSecondLine ? '_2' : ''); ?>" 
                class="form-control" 
                x-model="alleleAbbreviation"
                maxlength="4"
                placeholder=" "
            >
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="<?php echo e($prefix); ?>_gene_type<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Type of Gene <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
        <select name="<?php echo e($prefix); ?>_gene_type<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_gene_type<?php echo e($isSecondLine ? '_2' : ''); ?>" x-model="geneType" class="form-select">
            <option value="">Select type...</option>
            <?php $__currentLoopData = $geneTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group mb-3" x-show="geneType === 'other'">
        <label for="<?php echo e($prefix); ?>_other_gene_type<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Other Gene <?php if($isSecondLine): ?> 2 <?php endif; ?> Type</label>
        <input type="text" name="<?php echo e($prefix); ?>_other_gene_type<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_other_gene_type<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-control" x-model="otherGeneType" placeholder=" ">
    </div>

    <div class="form-group mb-3">
        <label for="<?php echo e($prefix); ?>_functional_change<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Functional Change <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
        <select name="<?php echo e($prefix); ?>_functional_change<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_functional_change<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-select" x-model="functionalChange">
            <option value="">Select change...</option>
            <?php $__currentLoopData = $functionalChangeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="<?php echo e($prefix); ?>_animal_strain<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-label">Animal Strain <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
        <select name="<?php echo e($prefix); ?>_animal_strain<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_animal_strain<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-select" x-model="mouseStrain">
            <option value="">Select strain...</option>
            <?php $__currentLoopData = $mouseStrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group mb-3" x-show="mouseStrain === 'other'">
        <label for="" class="form-label">Other Animal Strain <?php if($isSecondLine): ?> 2 <?php endif; ?></label>
        <input type="text" name="<?php echo e($prefix); ?>_other_animal_strain<?php echo e($isSecondLine ? '_2' : ''); ?>" id="<?php echo e($prefix); ?>_other_animal_strain<?php echo e($isSecondLine ? '_2' : ''); ?>" class="form-control" x-model="otherAnimalStrain" placeholder=" ">
    </div>
</div>
<?php /**PATH /var/www/resources/views/components/mouse-line-fields.blade.php ENDPATH**/ ?>