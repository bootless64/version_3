<?php

namespace App\Services;

use App\Models\SystemLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LoggingService
{
    
    public function logAuthenticationAttempt($email, $result, $error = null)
    {
        return $this->logEvent(
            'authentication_attempt',
            'auth',
            $result,
            'تلاش برای احراز هویت با ایمیل: ' . $email,
            null,
            [
                'email' => $email,
                'error' => $error,
                'ip' => Request::ip(),
            ]
        );
    }

    public function logAuthenticationResult($user, $result, $method = null)
    {
        return $this->logEvent(
            'authentication_result',
            'auth',
            $result,
            'نتیجه احراز هویت برای کاربر: ' . ($user ? $user->email : 'نامشخص'),
            $user ? $user->id : null,
            [
                'user_email' => $user ? $user->email : null,
                'method' => $method,
                'ip' => Request::ip(),
            ]
        );
    }

    public function logPasswordTest($email, $result)
    {
        return $this->logEvent(
            'password_test',
            'auth',
            $result,
            'تست کلمه عبور برای کاربر: ' . $email,
            null,
            [
                'email' => $email,
                'ip' => Request::ip(),
            ]
        );
    }

    public function logSessionCreate($result, $userId = null, $reason = null)
    {
        return $this->logEvent(
            'session_create',
            'session',
            $result,
            'تلاش برای ایجاد نشست',
            $userId,
            [
                'ip' => Request::ip(),
                'reason' => $reason,
            ]
        );
    }

    public function logSessionLimitExceeded($userId, $maxSessions)
    {
        return $this->logEvent(
            'session_limit_exceeded',
            'session',
            false,
            'تجاوز از محدودیت نشست‌های همزمان برای کاربر: ' . $userId,
            $userId,
            [
                'max_sessions' => $maxSessions,
                'ip' => Request::ip(),
            ]
        );
    }

    public function logSessionTerminated($userId, $terminatedBy, $reason = null)
    {
        $isAdmin = $terminatedBy === 'admin';
        return $this->logEvent(
            $isAdmin ? 'session_terminated_by_admin' : 'session_terminated_by_lock',
            'session',
            true,
            'خاتمه نشست برای کاربر: ' . $userId . ' توسط ' . $terminatedBy,
            $userId,
            [
                'terminated_by' => $terminatedBy,
                'reason' => $reason,
            ]
        );
    }

    public function logDataRead($entity, $entityId, $result, $userId = null)
    {
        return $this->logEvent(
            'data_read',
            'data',
            $result,
            'خواندن اطلاعات از ' . $entity . ' با شناسه ' . $entityId,
            $userId,
            [
                'entity' => $entity,
                'entity_id' => $entityId,
            ]
        );
    }

    public function logDataReadFailed($entity, $entityId, $error)
    {
        return $this->logEvent(
            'data_read_failed',
            'data',
            false,
            'خطا در خواندن اطلاعات از ' . $entity,
            null,
            [
                'entity' => $entity,
                'entity_id' => $entityId,
                'error' => $error,
            ]
        );
    }

    public function logDataCreate($entity, $entityId, $data, $userId = null)
    {
        return $this->logEvent(
            'data_create',
            'data',
            true,
            'ایجاد رکورد در ' . $entity,
            $userId,
            [
                'entity' => $entity,
                'entity_id' => $entityId,
                'data' => $data,
            ]
        );
    }

    public function logDataUpdate($entity, $entityId, $oldData, $newData, $userId = null)
    {
        return $this->logEvent(
            'data_update',
            'data',
            true,
            'به‌روزرسانی رکورد در ' . $entity,
            $userId,
            [
                'entity' => $entity,
                'entity_id' => $entityId,
                'old_data' => $oldData,
                'new_data' => $newData,
            ]
        );
    }

    public function logDataDelete($entity, $entityId, $data, $userId = null)
    {
        return $this->logEvent(
            'data_delete',
            'data',
            true,
            'حذف رکورد از ' . $entity,
            $userId,
            [
                'entity' => $entity,
                'entity_id' => $entityId,
                'data' => $data,
            ]
        );
    }

    public function logDataImport($result, $count = null, $errors = null)
    {
        return $this->logEvent(
            'data_import',
            'data',
            $result,
            'وارد کردن داده‌های کاربری',
            null,
            [
                'count' => $count,
                'errors' => $errors,
            ]
        );
    }

    public function logDataExport($result, $count = null, $userId = null)
    {
        return $this->logEvent(
            'data_export',
            'data',
            $result,
            'خارج کردن اطلاعات از محصول',
            $userId,
            [
                'count' => $count,
            ]
        );
    }

    public function logRoleCreated($roleName, $permissions, $userId = null)
    {
        return $this->logEvent(
            'role_created',
            'user_management',
            true,
            'ایجاد نقش جدید: ' . $roleName,
            $userId,
            [
                'role' => $roleName,
                'permissions' => $permissions,
            ]
        );
    }

    public function logRoleDeleted($roleName, $userId = null)
    {
        return $this->logEvent(
            'role_deleted',
            'user_management',
            true,
            'حذف نقش: ' . $roleName,
            $userId,
            [
                'role' => $roleName,
            ]
        );
    }

    public function logRolePermissionsUpdated($roleName, $oldPermissions, $newPermissions, $userId = null)
    {
        return $this->logEvent(
            'role_permissions_updated',
            'user_management',
            true,
            'تغییر مجوزهای نقش: ' . $roleName,
            $userId,
            [
                'role' => $roleName,
                'old_permissions' => $oldPermissions,
                'new_permissions' => $newPermissions,
            ]
        );
    }

    public function logUserAssignedToRole($userEmail, $roleName, $userId = null)
    {
        return $this->logEvent(
            'user_role_assigned',
            'user_management',
            true,
            'انتصاب کاربر ' . $userEmail . ' به نقش ' . $roleName,
            $userId,
            [
                'user' => $userEmail,
                'role' => $roleName,
            ]
        );
    }

    public function logUserRemovedFromRole($userEmail, $roleName, $userId = null)
    {
        return $this->logEvent(
            'user_role_removed',
            'user_management',
            true,
            'بازپس‌گیری نقش ' . $roleName . ' از کاربر ' . $userEmail,
            $userId,
            [
                'user' => $userEmail,
                'role' => $roleName,
            ]
        );
    }

    public function logUserGroupChanged($userEmail, $oldGroup, $newGroup, $userId = null)
    {
        return $this->logEvent(
            'user_group_changed',
            'user_management',
            true,
            'تغییر گروه کاربری برای ' . $userEmail,
            $userId,
            [
                'user' => $userEmail,
                'old_group' => $oldGroup,
                'new_group' => $newGroup,
            ]
        );
    }

    public function logSecurityAttributeChanged($userEmail, $attribute, $oldValue, $newValue, $userId = null)
    {
        return $this->logEvent(
            'security_attribute_changed',
            'security',
            true,
            'تغییر مشخصه امنیتی ' . $attribute . ' برای کاربر ' . $userEmail,
            $userId,
            [
                'user' => $userEmail,
                'attribute' => $attribute,
                'old_value' => $oldValue,
                'new_value' => $newValue,
            ]
        );
    }

    public function logSecurityFeatureFailed($feature, $error, $userId = null)
    {
        return $this->logEvent(
            'security_feature_failed',
            'security',
            false,
            'شکست در کارکرد امنیتی: ' . $feature,
            $userId,
            [
                'feature' => $feature,
                'error' => $error,
            ]
        );
    }

    public function logSecurityBindingAttempt($userEmail, $attribute, $result, $userId = null)
    {
        return $this->logEvent(
            'security_binding',
            'security',
            $result,
            'انقیاد مشخصه امنیتی ' . $attribute . ' برای کاربر ' . $userEmail,
            $userId,
            [
                'user' => $userEmail,
                'attribute' => $attribute,
            ]
        );
    }

    public function logFunctionStart($functionName, $parameters = null, $userId = null)
    {
        return $this->logEvent(
            'function_start',
            'system',
            true,
            'شروع اجرای تابع: ' . $functionName,
            $userId,
            [
                'function' => $functionName,
                'parameters' => $parameters,
            ]
        );
    }

    public function logFunctionEnd($functionName, $result = null, $duration = null, $userId = null)
    {
        return $this->logEvent(
            'function_end',
            'system',
            true,
            'پایان اجرای تابع: ' . $functionName,
            $userId,
            [
                'function' => $functionName,
                'result' => $result,
                'duration_ms' => $duration,
            ]
        );
    }

    public function logFunctionBehaviorChanged($functionName, $oldBehavior, $newBehavior, $userId = null)
    {
        return $this->logEvent(
            'function_behavior_changed',
            'system',
            true,
            'تغییر رفتار تابع: ' . $functionName,
            $userId,
            [
                'function' => $functionName,
                'old_behavior' => $oldBehavior,
                'new_behavior' => $newBehavior,
            ]
        );
    }

    public function logConfigurationChanged($key, $oldValue, $newValue, $userId = null)
    {
        return $this->logEvent(
            'configuration_changed',
            'system',
            true,
            'تغییر پیکربندی: ' . $key,
            $userId,
            [
                'key' => $key,
                'old_value' => $oldValue,
                'new_value' => $newValue,
            ]
        );
    }

    public function logMemoryOverflow($threshold, $usedMemory, $action, $userId = null)
    {
        return $this->logEvent(
            'memory_overflow',
            'system',
            true,
            'سرریز حافظه لاگ از حد آستانه',
            $userId,
            [
                'threshold' => $threshold,
                'used_memory' => $usedMemory,
                'action' => $action,
            ]
        );
    }

    public function logStorageFailed($storage, $error, $userId = null)
    {
        return $this->logEvent(
            'storage_failed',
            'system',
            false,
            'شکست در ذخیره‌سازی لاگ‌ها در ' . $storage,
            $userId,
            [
                'storage' => $storage,
                'error' => $error,
            ]
        );
    }

    public function logAdministrativeAction($action, $target, $result, $userId = null)
    {
        return $this->logEvent(
            'administrative_action',
            'admin',
            $result,
            'عملیات مدیریتی: ' . $action . ' روی ' . $target,
            $userId,
            [
                'action' => $action,
                'target' => $target,
            ]
        );
    }

    public function logEntityOperation($operation, $entity, $entityId, $result, $userId = null)
    {
        return $this->logEvent(
            'entity_operation',
            'entity',
            $result,
            'درخواست ' . $operation . ' بر روی موجودیت ' . $entity,
            $userId,
            [
                'operation' => $operation,
                'entity' => $entity,
                'entity_id' => $entityId,
            ]
        );
    }

    public function logEntityOperationFailed($operation, $entity, $entityId, $error, $userId = null)
    {
        return $this->logEvent(
            'entity_operation_failed',
            'entity',
            false,
            'شکست در ' . $operation . ' بر روی موجودیت غیرفعال ' . $entity,
            $userId,
            [
                'operation' => $operation,
                'entity' => $entity,
                'entity_id' => $entityId,
                'error' => $error,
            ]
        );
    }

    private function logEvent($eventType, $category, $result, $description, $userId = null, $details = null)
    {
        try {
            $resolvedUserId = $userId ?? (Auth::id() ?? null);
            
            $userName = null;
            if ($resolvedUserId) {
                $user = Auth::id() === $resolvedUserId
                    ? Auth::user()
                    : \App\Models\User::find($resolvedUserId);
                $userName = $user?->name;
            }

            return SystemLog::create([
                'event_time'    => now(),
                'event_type'    => $eventType,
                'event_category'=> $category,
                'event_result'  => $result,
                'user_id'       => $resolvedUserId,
                'user_name'     => $userName,
                'user_ip'       => Request::ip(),
                'user_agent'    => Request::userAgent(),
                'session_id'    => session()->getId(),
                'method'        => Request::method(),
                'url'           => Request::fullUrl(),
                'route_name'    => Request::route() ? Request::route()->getName() : null,
                'description'   => $description,
                'details'       => $details,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to store system log: ' . $e->getMessage());
            return null;
        }
    }

    public function getUserActivityLogs($userId, $limit = 50)
    {
        return SystemLog::where('user_id', $userId)
            ->orderBy('event_time', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLogsByType($eventType, $limit = 50)
    {
        return SystemLog::where('event_type', $eventType)
            ->orderBy('event_time', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLogsByCategory($category, $limit = 50)
    {
        return SystemLog::where('event_category', $category)
            ->orderBy('event_time', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getFailedLogs($limit = 50)
    {
        return SystemLog::where('event_result', false)
            ->orderBy('event_time', 'desc')
            ->limit($limit)
            ->get();
    }

    public function cleanupOldLogs($days = 30)
    {
        return SystemLog::where('event_time', '<', now()->subDays($days))->delete();
    }
}