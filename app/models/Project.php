<?php
class Project
{
    public static function forClient(int $clientId): array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM projects WHERE client_id = :client_id');
        $stmt->execute(['client_id' => $clientId]);
        return $stmt->fetchAll();
    }

    public static function findById(int $projectId): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute(['id' => $projectId]);
        $project = $stmt->fetch();

        return $project ?: null;
    }

    public static function findByToken(string $token): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM projects WHERE public_token = :token');
        $stmt->execute(['token' => $token]);
        $project = $stmt->fetch();

        return $project ?: null;
    }

    public static function phases(int $projectId): array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM phases WHERE project_id = :project_id');
        $stmt->execute(['project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public static function tasks(int $phaseId): array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM tasks WHERE phase_id = :phase_id');
        $stmt->execute(['phase_id' => $phaseId]);
        return $stmt->fetchAll();
    }
}
