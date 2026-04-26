# Performance Baseline (Smoke)

## Goal
Provide a lightweight, repeatable baseline check for API responsiveness.

## Implemented test
- File: `tests/Feature/PerformanceSmokeTest.php`
- Scenario: create 120 events, call `/api/v1/events` 15 times, compute p95-like sample from measured durations.
- Assertion threshold: p95-like sample < 800 ms (lenient local threshold to avoid flaky CI).

## Command
```powershell
php artisan test --filter=PerformanceSmokeTest
```

## Latest run
- Date: 2026-04-25
- Result: PASS
- Output snippet:
  - `PASS Tests\\Feature\\PerformanceSmokeTest`
  - `Duration: 1.08s`

## Interpretation
- This is a smoke indicator, not a production benchmark.
- It is enough for regression detection (sudden major slowdown).

## Next improvements
1. Add dedicated CLI benchmark (`hey` or `ab`) against running app.
2. Track p50/p95/p99 and error rate in CI artifact.
3. Add profile for authenticated endpoint latency too.
