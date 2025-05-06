<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamPageController extends Controller
{
        public function index()
    {
        $teamMembers = [
            'skeletal_biology' => [
                [
                    'name' => 'Peter Maye',
                    'institution' => 'University of Connecticut Health',
                    'department' => 'Department of Reconstructive Sciences, School of Dental Medicine',
                    'location' => 'Farmington, CT USA',
                ],
                [
                    'name' => 'Benjamin Sinder',
                    'institution' => 'University of Connecticut Health',
                    'department' => 'Department of Reconstructive Sciences, School of Medicine',
                    'location' => 'Farmington, CT USA',
                ],
                [
                    'name' => 'David Rowe',
                    'institution' => 'University of Connecticut Health',
                    'department' => 'Department of Reconstructive Sciences, School of Dental Medicine',
                    'location' => 'Farmington, CT USA',
                ],
                [
                    'name' => 'Thomas Andersen',
                    'institution' => 'University of Southern Denmark',
                    'department' => 'Molecular Bone Histology Lab (MBH)',
                    'location' => 'Odense, Denmark',
                ],
                [
                    'name' => 'Viktoria Bonne Kofod',
                    'institution' => 'University of Southern Denmark',
                    'department' => 'Molecular Bone Histology Lab (MBH)',
                    'location' => 'Odense, Denmark',
                ],
                [
                    'name' => 'Je-Yong Choi',
                    'institution' => 'Kyungpook National University',
                    'department' => 'Department of Biochemistry and Cell Biology',
                    'location' => 'Daegu, Republic of Korea',
                ],
            ],
            'computer_science' => [
                [
                    'name' => 'Joel Salisbury',
                    'institution' => 'University of Connecticut',
                    'department' => 'Digital Experience Group',
                    'location' => 'Storrs, CT USA',
                ],
                [
                    'name' => 'Brian Kelleher',
                    'institution' => 'UConn Digital Experience Group',
                    'department' => 'Digital Experience Group, UConn',
                    'location' => 'Storrs, CT USA',
                ],
                [
                    'name' => 'Jonathan Ameri',
                    'institution' => 'UConn Digital Experience Group',
                    'department' => 'Digital Experience Group, UConn',
                    'location' => 'Storrs, CT USA',
                ],
                [
                    'name' => 'Natalie Lacroix',
                    'institution' => 'UConn Digital Experience Group',
                    'department' => 'Digital Experience Group, UConn',
                    'location' => 'Storrs, CT USA',
                ],
                [
                    'name' => 'Dong-Guk Shin',
                    'institution' => 'UConn Department of Computer Science',
                    'department' => 'Department of Computer Science, UConn',
                    'location' => 'Storrs, CT USA',
                ],
                [
                    'name' => 'Chenyu Zhang',
                    'institution' => 'UConn Department of Computer Science',
                    'department' => 'Department of Computer Science, UConn',
                    'location' => 'Storrs, CT USA',
                ],
                [
                    'name' => 'Ion Mararu',
                    'institution' => 'University of Connecticut Health',
                    'department' => 'High Performance Computing Facility',
                    'location' => 'Farmington, CT USA',
                ],
                [
                    'name' => 'Michael Wilson',
                    'institution' => 'University of Connecticut Health',
                    'department' => 'High Performance Computing Facility',
                    'location' => 'Farmington, CT USA',
                ],
                [
                    'name' => 'Jim Schaff',
                    'institution' => 'University of Connecticut Health',
                    'department' => 'High Performance Computing Facility',
                    'location' => 'Farmington, CT USA',
                ],
            ]
        ];

        return view('about.teampage', compact('teamMembers'));
    }
}
    
