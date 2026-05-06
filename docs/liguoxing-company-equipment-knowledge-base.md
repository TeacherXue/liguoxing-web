# LIGUOXING Company & Equipment Knowledge Base

Last updated: 2026-05-06

## 1) Source Inventory

Primary files used:

- `docs/方底阀口制袋机.docx`
- `docs/技术讲解.pptx`
- `docs/BVM-120型方底阀口制袋机.pdf`
- `docs/方底阀口袋机介绍.pdf`
- `docs/利国兴宣传册.pdf`

Extraction artifacts (for traceability):

- `docs/extracted/docx_方底阀口制袋机.txt`
- `docs/extracted/docx_方底阀口制袋机_runs.txt`
- `docs/extracted/pptx_技术讲解_slides.txt`
- `docs/extracted/pdf_BVM-120型方底阀口制袋机_extract.txt`
- `docs/extracted/pdf_方底阀口袋机介绍_extract.txt`
- `docs/extracted/pdf_利国兴宣传册_extract.txt`

## 2) Extraction Notes

- DOCX text is fully extractable and is treated as the most reliable structured technical source.
- PPTX slide text is extractable from slide XML and provides process explanation, positioning, and additional parameters.
- PDF files are only partially extractable in this environment because:
  - no `pdftotext` / OCR toolchain is available;
  - at least part of the PDF content appears image-based or font-encoded.
- Therefore, web copy decisions prioritize data confirmed by DOCX + PPTX and only use PDF snippets when clearly readable.

## 3) Normalized Company Profile

Company name:

- LIGUOXING
- Full form used in docs: Qingdao LIGUOXING Precision Machinery Co., Ltd.

Business focus:

- Industrial packaging equipment for block bottom valve bags and open-mouth bags.
- Core capability: machine manufacturing + process implementation support.
- Technical route: hot-air forming, servo motion, sensor-based tracking, modular process stations.

Service scope:

- Pre-sales process evaluation
- Configuration and line matching
- Installation and commissioning
- Operator training
- Long-term service support

## 4) Product Positioning

Main model:

- BVM-120 type block bottom valve bag making machine.

Common English naming in source materials:

- Square Bottom Valve Bag Making Machine
- Block Bottom Valve Bag Making Machine
- Block Bottomer

Supported bag types:

- Block bottom valve bag
- Open-mouth bag

## 5) Confirmed Technical Parameters

Core parameters:

- Forming method: Hot Air
- Feasible material: Laminated PP tubular fabric
- Max speed: 120 pcs/min
- Typical operating speed: 90-115 pcs/min (depends on bag size/material/operator condition)
- Sack width: 350-600 mm
- Finished sack length: 450-910 mm
- Bottom width (valve type): 80-160 mm
- Installed power: 120 kW
- Actual consumption (presentation claim): about 85 kW
- Machine size: about 15 x 8.5 x 2.3 m (presentation also shows 15 x 9 x 2.3 m)

Bag-size related speed guidance from technical doc:

- Bottom width 8-9 cm: <=100 pcs/min
- Bottom width 10-11 cm: <=110 pcs/min
- Bottom width 12-13 cm: <=90 pcs/min
- Bottom width 14-16 cm: <=70 pcs/min

Material requirements:

- Too-high transparency material (>65%) not suitable
- Lamination peel strength >=2.7 N/cm
- Lamination trimming edge width <=5 mm

Utility requirements:

- Power: 380V, 3-phase AC, neutral + grounding
- Gas source: 0.7 MPa, 120 m3/h
- Water source: 0.4 MPa, 1 m3/h

## 6) Process Flow (Production Logic)

Typical production sequence:

1. Tubular fabric unwind
2. Cutting into individual bag pieces
3. Bottom end open
4. Valve patch application
5. Bottom patch application
6. Bottom end close
7. Counting / collection

## 7) Key Functional Modules

- Unwinding unit: auto tension, auto loading, EPC, compatible core sizes (8" / 3")
- Micro perforation: both sides, target density around 64 needles/cm2 (source wording)
- Conveying: servo-driven transport + mark tracking
- Punching/cutting: adjustable punching position, sensor/preset cutting length
- Turning/gripper transport: direction change, adjustable gripper spacing
- Valve forming: preheating + hot-air welding + online valve position adjustment
- Bottom forming: preheating + hot-air welding + online bottom-patch position adjustment
- Counting/ejecting: automatic counting, reject detection and removal
- Central control: PLC + modular I/O + HMI touch-screen control

## 8) Application Value Propositions (from PPT content)

- Cleaner filling environment with valve bag process
- Better dust control compared with traditional sewn bags
- Support for automated filling and downstream handling
- Stable quality for industrial powder/material packaging lines

## 9) Website Copy Rules (Derived)

To keep content accurate and aligned with source files:

- Use BVM-120 as the lead model on Equipment pages.
- Keep dimensional/speed claims in ranges, avoid absolute guarantees.
- Separate "Max speed" and "typical speed" language.
- Mention bag type compatibility (valve + open-mouth).
- Mention required utilities in Equipment/Contact context.
- Keep wording technical and operational rather than generic marketing-only language.

## 10) Website Copy Pack (Ready-to-Use)

Home headline direction:

- "BVM-120 Block Bottom Valve Bag Making Line"
- "Hot-Air Forming With Servo-Controlled Process Modules"
- "From Process Evaluation to Commissioning and Training"

About direction:

- Company specialization in industrial packaging equipment
- Integrated engineering, manufacturing, and service chain
- Module-level optimization and stable long-run output

Equipment direction:

- Full table with normalized specs
- Key module cards mapped to real process stations
- Utility and deployment notes

Application direction:

- Cement/building material
- Powder and granule products
- Automated filling + conveying + stacking downstream

Download direction:

- Keep all original source files listed and clearly named
- Add "presentation / technical document / brochure" labels

## 11) Open Items To Confirm Later

- Final official contact details (phone/address/email owner)
- Final "actual consumption" claim for public site (currently from PPT claim)
- Final machine size display value (15x8.5x2.3m vs 15x9x2.3m)
- Official English spellings for some terms (e.g., "Longger Valve" normalization)
