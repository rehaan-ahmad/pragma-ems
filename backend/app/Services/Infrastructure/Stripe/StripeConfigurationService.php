<?php

namespace HiEvents\Services\Infrastructure\Stripe;

use HiEvents\DomainObjects\Enums\StripePlatform;
use Illuminate\Support\Facades\Log;

class StripeConfigurationService
{
    public function getSecretKey(?StripePlatform $platform = null): ?string
    {
        return match ($platform) {
            StripePlatform::CANADA => config('services.stripe.ca_secret_key', config('services.stripe.secret_key')),
            StripePlatform::IRELAND => config('services.stripe.ie_secret_key', config('services.stripe.secret_key')),
            StripePlatform::INDIA => config('services.stripe.in_secret_key', config('services.stripe.secret_key')),
            default => config('services.stripe.secret_key'),
        };
    }

    public function getPublicKey(?StripePlatform $platform = null): ?string
    {
        return match ($platform) {
            StripePlatform::CANADA => config('services.stripe.ca_public_key', config('services.stripe.public_key')),
            StripePlatform::IRELAND => config('services.stripe.ie_public_key', config('services.stripe.public_key')),
            StripePlatform::INDIA => config('services.stripe.in_public_key', config('services.stripe.public_key')),
            default => config('services.stripe.public_key'),
        };
    }

    public function getPrimaryPlatform(): ?StripePlatform
    {
        $platformString = config('services.stripe.primary_platform');
        return StripePlatform::fromString($platformString);
    }

    public function getAllWebhookSecrets(): array
    {
        $secrets = array_filter([
            'default' => config('services.stripe.webhook_secret'),
            StripePlatform::CANADA->value => config('services.stripe.ca_webhook_secret'),
            StripePlatform::IRELAND->value => config('services.stripe.ie_webhook_secret'),
            StripePlatform::INDIA->value => config('services.stripe.in_webhook_secret'),
        ]);

        // Validate India webhook secret if India platform is being used
        $this->validateIndiaWebhookSecret($secrets);

        // order by primary platform first
        $primary = $this->getPrimaryPlatform()?->value;

        if ($primary && isset($secrets[$primary])) {
            $primarySecret = [$primary => $secrets[$primary]];
            unset($secrets[$primary]);
            return $primarySecret + $secrets;
        }

        return $secrets;
    }

    /**
     * Validate that India webhook secret is configured when India platform is in use.
     */
    private function validateIndiaWebhookSecret(array $secrets): void
    {
        $indiaSecret = $secrets[StripePlatform::INDIA->value] ?? null;
        $primaryPlatform = $this->getPrimaryPlatform();

        // Check if India is the primary platform or if India secret is explicitly set but webhook secret is missing
        $indiaKeysConfigured = config('services.stripe.in_secret_key') !== config('services.stripe.secret_key')
            || config('services.stripe.in_public_key') !== config('services.stripe.public_key');

        if (($primaryPlatform === StripePlatform::INDIA || $indiaKeysConfigured) && !$indiaSecret) {
            Log::warning('India Stripe platform is configured but STRIPE_IN_WEBHOOK_SECRET is not set. Webhook verification for India platform will fail.', [
                'primary_platform' => $primaryPlatform?->value,
                'india_keys_configured' => $indiaKeysConfigured,
            ]);
        }
    }
}
