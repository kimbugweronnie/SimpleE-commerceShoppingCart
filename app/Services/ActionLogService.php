<?php
namespace App\Services;

use App\Models\ActionLog;

class ActionLogService
{
    //creating an action log 
    public function log(int $userId,string $action,string $subjectType,int $subjectId, array $properties = []): void 
    {
        ActionLog::create([
            'user_id' => $userId,
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'properties' => $properties,
        ]);
    }
}

?>