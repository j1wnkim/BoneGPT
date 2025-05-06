<?php $__env->startSection('title', 'RAG Information'); ?>

<?php $__env->startSection('content'); ?>
<style>
    h1 {
        font-size: 4.5rem; /* Adjust as needed */
    }
    h2 {
        font-size: 3rem; /* Adjust as needed */
    }
    h3 {
        font-size: 1.75rem; /* Adjust as needed */
    }
</style>
<div class="container">
    <h1 class="mb-4">RAG Summary</h1>

    <!-- Study Information Section -->
    <div class="section">
        <h2>Study Information</h2>
        <p><strong>Title:</strong> <span id="title"></span></p>
        <p><strong>Summary:</strong> <span id="summary"></span></p>
        <p><strong>Funding:</strong> <span id="funding"></span></p>
        <p><strong>Conflicts of Interest:</strong> <span id="conflicts"></span></p>
        <p><strong>Date Published:</strong> <span id="date"></span></p>
        <p><strong>Publication Status:</strong> <span id="published"></span></p>
        <p><strong>Summary Chunks:</strong> <span id="SChunks"></span></p>
    </div>

    <!-- Study Details Section -->
    <div class="section">
        <div>
            <h2>Subject Areas</h2>
            <ul id="subject-areas"></ul>
        </div>
        <div>
            <h2>Investigators</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Organization</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody id="investigatorTableBody">
                </tbody>
            </table>
        </div>
        <div>
            <h2>Experimental Groups</h2>
            <ul id="experimental-groups"></ul>
        </div>
        <div>
            <h2>Phenotype Analysis</h2>
            <ul id="phenotype-analysis"></ul>
        </div>
    </div>
</div>

<script>
    function addRow(firstName, lastName, email, department, organization, country) {
        let table = document.getElementById("tableBody");
        let row = table.insertRow();

        let firstNameCell = row.insertCell();
        let lastNameCell = row.insertCell();
        let emailCell = row.insertCell();
        let departmentCell = row.insertCell();
        let organizationCell = row.insertCell();
        let countryCell = row.insertCell();

        firstNameCell.innerHTML = firstName;
        lastNameCell.innerHTML = lastName;
        emailCell.innerHTML = email;
        departmentCell.innerHTML = department;
        organizationCell.innerHTML = organization;
        countryCell.innerHTML = country;
    }

    fetch('/study-data')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const study = data;
            document.getElementById("title").textContent = study.study_information.studyTitle;
            document.getElementById("summary").textContent = study.study_information.studySummary;
            document.getElementById("funding").textContent = study.study_information.funding;
            document.getElementById("conflicts").textContent = study.study_information.conflicts;
            document.getElementById("date").textContent = study.study_information.Date;
            document.getElementById("published").textContent = study.study_information.published ? "Published" : "Not Published";
            document.getElementById("SChunks").textContent = study.study_information.summary_chunks;

            // document.getElementById("investigators").textContent = study.investigators.investigator_info;

            const subjectAreaLists = ['list1', 'list2', 'list3', 'list4'];
            let subjectAreasHtml = '';
            subjectAreaLists.forEach(listKey => {
                const items = study.subject_areas[listKey] || [];
                if (items.length > 0) {
                    subjectAreasHtml += `<strong>${listKey.replace('list', 'List ')}</strong>:<br>`;
                    items.forEach(item => {
                        subjectAreasHtml += `${item}<br>`;
                    });
                }
            });
            document.getElementById("subject-areas").innerHTML = subjectAreasHtml;

            // const EGLists = ['0', '1'];
            // let EGHtml = '';
            // EGLists.forEach(listKey => {
            //     const items = study.experimental_groups[listKey] || [];
            //     if (items.length > 0) {
            //         EGHtml += `<strong>${listKey.replace('list', 'List ')}</strong>:<br>`;
            //         items.forEach(item => {
            //             EGHtml += `${item}<br>`;
            //         });
            //     }
            // });
            // document.getElementById("experimental-groups").innerHTML = EGHtml;
            const EGLists = ['0', '1'];
// Mapping keys to custom labels
            const labels = {
                '0': 'experimental categories',
                '1': 'Additional description'
            };
            let EGHtml = '';
            EGLists.forEach(listKey => {
                const items = study.experimental_groups[listKey] || [];
                if (items.length > 0) {
                    // Use the mapped label instead of the raw key
                    EGHtml += `<strong>${labels[listKey]}</strong>:<br>`;
                    items.forEach(item => {
                        EGHtml += `${item}<br>`;
                    });
                }
            });
            document.getElementById("experimental-groups").innerHTML = EGHtml;



            // const PALists = ['groups'];
            // let PAHtml = '';
            // PALists.forEach(listKey => {
            //     const items = study.phenotype_analysis[listKey] || [];
            //     if (items.length > 0) {
            //         PAHtml += `<strong>${listKey.replace('list', 'List ')}</strong>:<br>`;
            //         items.forEach(item => {
            //             PAHtml += `${item}<br>`;
            //         });
            //     }
            // });

            // document.getElementById("phenotype-analysis").innerHTML = PAHtml;
            const PALists = ['groups'];
            let PAHtml = '';
            PALists.forEach(listKey => {
                const items = study.phenotype_analysis[listKey] || [];
                if (items.length > 0) {
                    PAHtml += `<strong>${listKey.replace('list', 'List ')}</strong>:<br>`;
                    items.forEach(item => {
                        // Remove parentheses and extra whitespace
                        let cleanItem = item.trim().replace(/[()]/g, '');
                        // Split into components (first is gender flag, second is weeks)
                        let parts = cleanItem.split(',');
                        let genderIndicator = parts[0].trim();
                        // Map 1 to 'Male' and 0 to 'Female'
                        let gender = (genderIndicator === '1') ? 'Male' : 'Female';
                        // Retrieve the weeks value if available, and append "weeks"
                        let weeks = parts.length > 1 ? parts[1].trim() + ' weeks' : '';
                        // Build the output string in the desired format
                        PAHtml += `${gender}, ${weeks}<br>`;
                    });
                }
            });

            // Update the element's HTML with the generated content
            document.getElementById("phenotype-analysis").innerHTML = PAHtml;


        })
        .catch(error => {
            console.error('Error fetching the study data:', error);
        });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/rag.blade.php ENDPATH**/ ?>