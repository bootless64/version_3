<?php

namespace App\Http\Controllers;

use App\Models\BannedIp;
use App\Services\LoggingService;
use Illuminate\Http\Request;

class BanIpController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip'     => 'required|ip',
            'reason' => 'nullable|string|max:255',
        ]);

        if (BannedIp::where('ip', $validated['ip'])->exists()) {
            return back()->with('error', 'این آی‌پی قبلاً بن شده است.');
        }

        BannedIp::create([
            'ip'        => $validated['ip'],
            'reason'    => $validated['reason'] ?? null,
            'banned_by' => auth()->id(),
        ]);

        $this->logger->logAdministrativeAction(
            'ban_ip',
            $validated['ip'],
            true,
            auth()->id()
        );

        return back()->with('success', 'آی‌پی ' . $validated['ip'] . ' با موفقیت بن شد.');
    }

    public function destroy($id)
    {
        $banned = BannedIp::findOrFail($id);

        $this->logger->logAdministrativeAction(
            'unban_ip',
            $banned->ip,
            true,
            auth()->id()
        );

        $banned->delete();

        return back()->with('success', 'بن آی‌پی ' . $banned->ip . ' برداشته شد.');
    }
}
