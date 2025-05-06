
<?php if(request()->route() &&
        in_array(request()->route()->getName(), [
            'study.study-information',
            'study.subject-areas',
            'study.investigators',
            'study.animal-experimentation',
            'study.experimental-groups',
            'study.phenotype-analysis',
            'study.summary',
        ])): ?>
    <div class="study-nav">
        <div class="container border-bottom py-2">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">Study ID: </span>
            </div>
        </div>
        <nav class="navbar border-bottom">
            <div class="container">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.study-information'),
                            'opacity-50' => !Route::is('study.study-information'),
                        ]); ?>"
                            href="<?php echo e(route('study.study-information', ['study' => 1])); ?>">
                            Study Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.subject-areas'),
                            'opacity-50' => !Route::is('study.subject-areas'),
                        ]); ?>"
                            href="<?php echo e(route('study.subject-areas', ['study' => 1])); ?>">
                            Subject Areas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.investigators'),
                            'opacity-50' => !Route::is('study.investigators'),
                        ]); ?>"
                            href="<?php echo e(route('study.investigators', ['study' => 1])); ?>">
                            Investigators
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.animal-experimentation'),
                            'opacity-50' => !Route::is('study.animal-experimentation'),
                        ]); ?>"
                            href="<?php echo e(route('study.animal-experimentation', ['study' => 1])); ?>">
                            Animal Experimentation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.experimental-groups'),
                            'opacity-50' => !Route::is('study.experimental-groups'),
                        ]); ?>"
                            href="<?php echo e(route('study.experimental-groups', ['study' => 1])); ?>">
                            Experimental Groups
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.phenotype-analysis'),
                            'opacity-50' => !Route::is('study.phenotype-analysis'),
                        ]); ?>"
                            href="<?php echo e(route('study.phenotype-analysis', ['study' => 1])); ?>">
                            Phenotype Analysis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('study.summary'),
                            'opacity-50' => !Route::is('study.summary'),
                        ]); ?>" href="<?php echo e(route('study.summary', ['study' => 1])); ?>">
                            Summary
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'nav-link text-dark hover-nav-link',
                            'active text-dark fw-bold' => Route::is('rag.summary'),
                            'opacity-50' => !Route::is('rag.summary'),

                        ]); ?>" href="<?php echo e(route('rag.summary', ['study' => 1])); ?>">
                            RAG Information
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/resources/views/components/study-nav.blade.php ENDPATH**/ ?>