<?php
function get_jobs(PDO $pdo, int $employer_id): array
{
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE employer_id = :employer_id ORDER BY created_at DESC");
    $stmt->execute([':employer_id' => $employer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function post_job(PDO $pdo, array $data): bool
{
    $sql = "
        INSERT INTO job_postings
            (employer_id, job_title, job_description, required_skills,
             work_type, arrangement, accessibility_features)
            VALUES
            (:employer_id, :job_title, :job_description, :required_skills,
             :work_type, :arrangement, :accessibility_features)
    ";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

