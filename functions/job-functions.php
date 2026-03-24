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
function update_job(PDO $pdo, int $job_id, array $data): bool
{
    $sql = "
        UPDATE job_postings
        SET title = :title,
            description = :job_description,
            required_skills = :required_skills,
            work_type = :work_type,
            arrangement = :arrangement,
            accessibility_features = :accessibility_features,
            status = :status
        WHERE job_id = :job_id
    ";
    $stmt = $pdo->prepare($sql);
    $data[':job_id'] = $job_id;
    return $stmt->execute($data);
}

