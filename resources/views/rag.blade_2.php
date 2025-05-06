@extends('layout')

@section('title', 'RAG Information')

@section('content')
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


    <div class="section">
        <h2>Investigator</h2>
        <p><strong>First Name:</strong> <span id="first-name"></span></p>
        <p><strong>Last Name:</strong> <span id="last-name"></span></p>
        <p><strong>Email:</strong> <span id="email"></span></p> 
        <p><strong>Institution:</strong> <span id="institution"></span></p>
        <p><strong>Department Name:</strong> <span id="department-name"></span></p>
        <p><strong>Organization: </strong> <span id="organization"></span></p>
        <p><strong>Country: </strong> <span id="country"></span></p> 

    <!-- Study Details Section -->
    <div class="section">
        <div>
            <h2>Subject Areas</h2>
            <ul id="subject-areas"></ul>
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

      const EGLists = ['0', '1'];
      let EGHtml = '';
      EGLists.forEach(listKey => {
        const items = study.experimental_groups[listKey] || [];
        if (items.length > 0) {
          EGHtml += `<strong>${listKey.replace('list', 'List ')}</strong>:<br>`;
          items.forEach(item => {
            EGHtml += `${item}<br>`;
          });
        }
      }); // add in the investigators group then!! 
      





      document.getElementById("experimental-groups").innerHTML = EGHtml; 

      const PALists = ['groups'];
      let PAHtml = '';
      PALists.forEach(listKey => {
        const items = study.phenotype_analysis[listKey] || [];
        if (items.length > 0) {
          PAHtml += `<strong>${listKey.replace('list', 'List ')}</strong>:<br>`;
          items.forEach(item => {
            PAHtml += `${item}<br>`;
          });
        }
      });
      document.getElementById("phenotype-analysis").innerHTML = PAHtml;
    })
    .catch(error => {
      console.error('Error fetching the study data:', error);
    });
</script>

@endsection