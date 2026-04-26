# UX Self Assessment

Date: 2026-04-25
Scale: 1 (low) to 5 (high)

| Criteria | Score | Rationale |
|---|---:|---|
| Visual consistency (color, typography, spacing) | 3 | Main patterns are consistent, but tokens are not fully formalized in code. |
| Information hierarchy and readability | 4 | Screen structures are readable and task-driven, especially in event and profile flows. |
| Feedback quality (loading, validation, error, success) | 3 | Validation and success feedback exist, but loading and async feedback can be improved. |
| Error and empty state handling | 3 | Basic empty/error handling exists, but screenshots and explicit UX specs were missing until now. |
| Mobile and desktop coverage | 3 | Responsive behavior exists, but full dual-form-factor evidence pack is not finished yet. |
| Accessibility (a11y) | 2 | Foundational patterns are present, but no formal audit evidence exists. |
| Onboarding and new user experience | 3 | Login/register flows are functional, but onboarding guidance can be clearer. |
| Perceived performance | 3 | App feels responsive in normal flows; no dedicated UX latency instrumentation shown yet. |

## Reflection

The strongest UX area is the core event lifecycle: browse, open details, comment, and manage own events. The current UI remains practical and understandable for thesis MVP scope.

If two more weeks were available, priority improvements would be a full screenshot evidence pack for mobile and desktop, explicit empty/loading/error states on each key screen, and one accessibility pass with contrast and keyboard-only validation.

The major gap was submission packaging discipline: implementation existed, but the formal docs/ux structure was not delivered in time. This is now being closed with a complete UX documentation package and traceable artifacts.
