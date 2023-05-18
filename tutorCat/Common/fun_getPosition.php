<?php

function getPosition()
{
    if (isset($_SESSION['TutorID']) || isset($_SESSION['StudentID'])) {

        if (isset($_SESSION['TutorID'])) {
            return 'Tutor';
        }
        if (isset($_SESSION['StudentID'])) {
            return 'Student';
        }
    } else {
        return 'Guest';
    }
}
