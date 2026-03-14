<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCertificateDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $certificateDate = \Carbon\Carbon::parse($value);
        $now = \Carbon\Carbon::now();
        $currentYear = $now->year;
        $previousYear = $now->copy()->subYear()->year;

        // Allow dates from current year
        $yearStart = \Carbon\Carbon::createFromDate($currentYear, 1, 1);
        
        // Allow dates from January of previous year (grace period)
        $gracePeriodStart = \Carbon\Carbon::createFromDate($previousYear, 1, 1);
        $gracePeriodEnd = \Carbon\Carbon::createFromDate($currentYear, 1, 31);

        // Check if date is in the future
        if ($certificateDate->isFuture()) {
            $fail('Tanggal sertifikat tidak boleh di masa depan.');
            return;
        }

        // Check if date is within valid range
        // Valid: Current year (Jan 1 - Dec 31) OR Previous year January only (grace period)
        $isValidCurrentYear = $certificateDate->gte($yearStart);
        $isGracePeriod = $certificateDate->gte($gracePeriodStart) && $certificateDate->lte($gracePeriodEnd);

        if (!$isValidCurrentYear && !$isGracePeriod) {
            $fail('Tanggal sertifikat harus tahun ' . $currentYear . ' atau Januari ' . $currentYear . ' (masa tenggang 1 bulan).');
        }
    }
}
