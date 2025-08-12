<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Admin;
use App\Http\Controllers\API\ServiceAccountController;
use Illuminate\Http\Request;

class GenerateServiceAccountToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;
    protected $serviceName;
    protected $description;
    protected $password;

    /**
     * Create a new job instance.
     *
     * @param Admin $admin
     * @param string $serviceName
     * @param string $description
     * @param string $password
     * @return void
     */
    public function __construct(Admin $admin, $serviceName = null, $description = null, $password = null)
    {
        $this->admin = $admin;
        $this->serviceName = $serviceName ?? 'Bansal Immigration CRM';
        $this->description = $description ?? 'Service account token for admin authentication';
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Use provided password, fallback to decrypt_password, then default
            $adminPassword = $this->password ?: $this->admin->decrypt_password ?: 'admin123';
            
            // Create a mock request object
            $request = new Request([
                'service_name' => $this->serviceName,
                'description' => $this->description,
                'admin_email' => $this->admin->email,
                'admin_password' => $adminPassword,
            ]);

            // Call the controller method directly instead of making HTTP request
            $controller = new ServiceAccountController();
            $response = $controller->generateToken($request);
            
            // Get the response data
            $result = json_decode($response->getContent(), true);

            if ($result && isset($result['success']) && $result['success']) {
                // Update the admin record
                $this->admin->update([
                    'service_token' => $result['token'] ?? null,
                    'token_generated_at' => now()
                ]);
                
                Log::info('Service account token generated successfully in background job', [
                    'admin_id' => $this->admin->id,
                    'admin_email' => $this->admin->email,
                    'token' => $result['token'] ?? 'N/A'
                ]);
            } else {
                Log::error('Failed to generate service account token in background job', [
                    'admin_id' => $this->admin->id,
                    'admin_email' => $this->admin->email,
                    'response' => $result
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while generating service account token in background job', [
                'admin_id' => $this->admin->id,
                'admin_email' => $this->admin->email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Service account token generation job failed', [
            'admin_id' => $this->admin->id,
            'admin_email' => $this->admin->email,
            'error' => $exception->getMessage()
        ]);
    }
} 