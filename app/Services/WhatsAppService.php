<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message using Fonnte API Gateway.
     *
     * @param string $target Recipient phone number (e.g. 08123456789 or +628123456789)
     * @param string $message The message body content to send
     * @return array Response payload with 'success' and 'message' keys
     */
    public static function sendMessage(string $target, string $message): array
    {
        // Sanitize phone number to standard international format or Fonnte compatible format
        $target = self::sanitizePhoneNumber($target);

        // Fetch Fonnte token from environment configuration
        $token = env('FONNTE_TOKEN');

        if (empty($token) || $token === 'your_fonnte_token_here') {
            // Simulated fallback log for testing local environment without real token
            Log::info("=== WHATSAPP GATEWAY SIMULATION ===");
            Log::info("Recipient (WhatsApp): " . $target);
            Log::info("Message: " . $message);
            Log::info("====================================");

            return [
                'success' => true,
                'message' => 'Layanan simulasi: WhatsApp berhasil dicatat di log Laravel (Token Fonnte belum diatur).',
                'simulated' => true
            ];
        }

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62', // Default Indonesia
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                Log::error("Fonnte cURL Error: " . $err);
                return [
                    'success' => false,
                    'message' => 'Gagal menghubungi server WhatsApp: ' . $err
                ];
            }

            $result = json_decode($response, true);
            
            if (isset($result['status']) && $result['status'] === true) {
                return [
                    'success' => true,
                    'message' => 'WhatsApp OTP berhasil dikirim!'
                ];
            }

            Log::warning("Fonnte API Warning: " . ($result['reason'] ?? $response));
            return [
                'success' => false,
                'message' => 'WhatsApp API response: ' . ($result['reason'] ?? 'Gagal memproses pesan')
            ];

        } catch (\Exception $e) {
            Log::error("WhatsApp Service Exception: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal memproses pengiriman: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Standardize phone numbers to be compatible with WhatsApp / Fonnte
     */
    private static function sanitizePhoneNumber(string $phone): string
    {
        // Remove spaces, hyphens, parentheses, etc.
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If phone number starts with '0', replace with '62' (Indonesia Country Code)
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}
