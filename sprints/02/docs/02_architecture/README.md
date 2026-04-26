# Architecture Documentation

## Contents
- `c4_context.mmd` — C4 level 1 context view
- `c4_container.mmd` — C4 level 2 container view
- `quality_attributes.md` — non-functional requirements and measurable scenarios
- `adr/` — architecture decision records (0001..0008)

## Diagram export
If Mermaid CLI is available, export with:

```powershell
npx @mermaid-js/mermaid-cli -i docs/02_architecture/c4_context.mmd -o docs/02_architecture/c4_context.svg
npx @mermaid-js/mermaid-cli -i docs/02_architecture/c4_container.mmd -o docs/02_architecture/c4_container.svg
npx @mermaid-js/mermaid-cli -i docs/02_architecture/c4_context.mmd -o docs/02_architecture/c4_context.png
npx @mermaid-js/mermaid-cli -i docs/02_architecture/c4_container.mmd -o docs/02_architecture/c4_container.png
```

Note: in the current environment `npm` is not available, so export should be executed in CI or on a machine with Node.js installed.
