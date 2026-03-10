<?php
function get_seeker_profile(PDO $pdo, int $user_id): ?array
{
    $stmt = $pdo->prepare("SELECT * FROM seeker_profiles WHERE user_id = :user_id LIMIT 1");
    $stmt->execute([':user_id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

function save_seeker_profile(PDO $pdo, array $data): bool
{
    $sql = "
        INSERT INTO seeker_profiles
            (user_id, full_name, phone, location, skills,
             accessibility_needs, work_preference, bio, resume_path)
        VALUES
            (:user_id, :full_name, :phone, :location, :skills,
             :accessibility_needs, :work_preference, :bio, :resume_path)
        ON DUPLICATE KEY UPDATE
            full_name            = VALUES(full_name),
            phone                = VALUES(phone),
            location             = VALUES(location),
            skills               = VALUES(skills),
            accessibility_needs  = VALUES(accessibility_needs),
            work_preference      = VALUES(work_preference),
            bio                  = VALUES(bio),
            resume_path          = IF(VALUES(resume_path) != '', VALUES(resume_path), resume_path)
    ";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':user_id'             => (int)  $data['user_id'],
        ':full_name'           => trim($data['full_name']           ?? ''),
        ':phone'               => trim($data['phone']               ?? ''),
        ':location'            => trim($data['location']            ?? ''),
        ':skills'              => trim($data['skills']              ?? ''),
        ':accessibility_needs' => trim($data['accessibility_needs'] ?? ''),
        ':work_preference'     => trim($data['work_preference']     ?? 'Remote'),
        ':bio'                 => trim($data['bio']                 ?? ''),
        ':resume_path'         => trim($data['resume_path']         ?? ''),
    ]);
}

function get_employer_profile(PDO $pdo, int $user_id): ?array
{
    $stmt = $pdo->prepare("SELECT * FROM employer_profiles WHERE user_id = :user_id LIMIT 1");
    $stmt->execute([':user_id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

function save_employer_profile(PDO $pdo, array $data): bool
{
    $sql = "
        INSERT INTO employer_profiles
            (user_id, company_name, industry, location, description,
                contact_email)
        VALUES
            (:user_id, :company_name, :industry, :location, :description,
                :contact_email)
        ON DUPLICATE KEY UPDATE
            company_name   = VALUES(company_name),
            industry       = VALUES(industry),
            location       = VALUES(location),
            description    = VALUES(description),
            contact_email  = VALUES(contact_email)
    "; 
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':user_id'      => (int)  $data['user_id'],
        ':company_name' => trim($data['company_name'] ?? ''),
        ':industry'     => trim($data['industry']     ?? ''),
        ':location'     => trim($data['location']     ?? ''),
        ':description'  => trim($data['description']  ?? ''),
        ':contact_email'=> trim($data['contact_email']?? ''),
    ]);
}
