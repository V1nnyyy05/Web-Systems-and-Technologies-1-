<?php
function canEnroll($studentId, $subjectId, $conn) {
    
    $stmt = $conn->prepare("SELECT prereq_subject_id FROM prerequisites WHERE subject_id = ?");
    $stmt->execute([$subjectId]);
    $prerequisites = $stmt->fetchAll(PDO::FETCH_COLUMN);


    if (empty($prerequisites)) {
        return true;
    }
  
    foreach ($prerequisites as $prereqId) {
        $stmt = $conn->prepare("
            SELECT e.status, g.grade 
            FROM enrollments e
            LEFT JOIN grades g ON e.enrollment_id = g.enrollment_id
            WHERE e.student_id = ? AND e.subject_id = ?
        ");
        $stmt->execute([$studentId, $prereqId]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record || $record['status'] !== 'completed') {
            return false;
        }
        if ($record['grade'] == '5.0' || $record['grade'] == 'INC' || empty($record['grade'])) {
            return false;
        }
    }
    return true;
}

function getPrerequisiteNames($subjectId, $conn) {
    $stmt = $conn->prepare("
        SELECT s.subject_name 
        FROM prerequisites p
        JOIN subjects s ON p.prereq_subject_id = s.subject_id
        WHERE p.subject_id = ?
    ");
    $stmt->execute([$subjectId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}