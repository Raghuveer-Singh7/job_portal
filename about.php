<?php
include 'header.php';
?>

<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Georgia, 'Times New Roman', Times, serif;
    }
    #header{
        height: 5vh;
        background-color: rgb(161, 161, 249);
    }
    hr{
        background-color: rgb(0, 0, 0);
        height: 5px;
    }
    #categories{
        color: blue;
    }
    ul li{
        list-style: square;
    }
</style>

<a href="index.php">Home</a>

<div class="container">

    <h4 id="header"><b>ABOUT</b></h4>

    <div>
        The Job-Portal is developed using following tech stack : <br>
        <b>Frontened : </b> HTML , CSS (and Bootstrap) , Javascript (and Ajax) <br>
        <b>Backend :</b> PHP <br>
        <b>Database :</b> MySQL <br>
        <br>
        <b>There are three categories which can use this Job-Portal : </b>
        <ol>
            <li>Admin</li>
            <li>Recruiters</li>
            <li>Candidates</li>
        </ol>
    </div>

    <hr>

    <div>
        <h5 id="categories">1. Admin</h5>
        Admin is made initially with its role defined as 'admin' which differentiate him from the other two 
        categories. On registration page there are only two options to get started with is either as a Recruiters
        or as a Candidate. <br>
        Admin can login using the email and password and can view and manage Recruiters and Candidates. <br>
        <br>
        <b>Admin's permission for 'Recruiters' : </b>
        <ol>
            <li>See all the registered recruiters along with their login credentials</li>
            <li>Update the status to 'Active' and 'Not Active' based on which jobs posted by them appear on candidate's 'available jobs' page. </li>
            <li>Check each job posting by each recruiter</li>
            <li>Check applicants for each job posting</li>
            <li>View uploaded resume and delete the particular application</li>
        </ol>
        <b>Admin's permission for 'Candidates' : </b>
        <ol>
            <li>See all the registered candidates along with their login credentials</li>
            <li>Update the status to 'Active' and 'Not Active' based on which they appear on recruiter's listed job's applicants list.</li>
            <li>View all of their applications</li>
            <li>View uploaded resume and delete the particular application</li>
        </ol>
    </div>

    <hr>

    <div>
        <h5 id="categories">2. Recruiters</h5> 
        Recruiters can register themselves with the asked fields, It's recommended for them to use their company name 
        for registration as that will be their display name. <br>
        Recruiters can login using the email and password. <br>
        <br>
        <b>What recruiter can do ?</b>
        <ol>
            <li>Create a new job posting
                <ul>
                    <li>Simply creating a new job posting by filling the form.</li>
                </ul>
            </li>
            <li>Check jobs posted by them.
                <ul>
                    <li>View all the applicants of the particular job and view their resume.</li>
                </ul>
            </li>
            <li>Edit the posted jobs.
                <ul>
                    <li>In addition with the all filed available at the time of creating a job recruiter will
                        get a option to update the status to 'Active' and 'Not Active' based on which that
                        particular job appear in the 'available jobs' list in candidate's feed.
                    </li>
                    <li>
                        After the current date the job would no longer be displayed at candidate's feed so that
                        can be edited in case the hiring is extended.
                    </li>
                </ul>
            </li>
            
        </ol>

    </div>

    <hr>

    <div>
       <h5 id="categories">3. Candidates</h5>
        Candidates can register themselves with the asked fields, It's recommended for them to use their Full name 
        for registration as that will be their display name. <br>
        Candidates can login using the email and password. All the available jobs (whose last date is not been passed) 
        will appear on feed (landing page) <br>
        <br>
        <b>What candidate can do ?</b>
        <ol>
            <li>View and apply to job of their choice.</li>
            <li>Check all the jobs they have already applied and their current status
                <ul>
                    <li>Status include the date on which they have applied and date on which recruiter have viewd their 
                        application</li>
                    <li>
                        Check their submitted resume
                    </li>
                    
                </ul>
            </li>
        </ol>

    </div>

    <hr>
    
</div>