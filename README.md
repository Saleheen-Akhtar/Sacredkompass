# Sacred Kompass WordPress Theme — v4.0.0

## Design Direction
**Spiritual · Angelic · Celestial Calmness**
- Palette: Warm ivory, sacred terracotta, parchment, soft gold accents, celestial light glows
- Fonts: Cormorant Garamond (display) + Jost (UI labels)
- Layout: Single scrollable page, sticky transparent→solid nav
- Hero: Editorial split — scroll-driven narrative left, parallax image right
- Animations: Scroll reveals, parallax, floating celestial orbs, scroll progress bar
- Goal: Book a Free Discovery Call (Forminator contact form embedded in-page)

---

## Required Plugins
| Plugin | Purpose |
|--------|---------|
| **Advanced Custom Fields (ACF) Pro** | All editable content (hero, offerings, FAQ, founders) |
| **Forminator** | In-page contact form (single-page, no redirect) |

---

## Installation
1. Zip the `sacred-kompass/` folder
2. WordPress Admin → Appearance → Themes → Add New → Upload Theme
3. Activate theme
4. Install ACF Pro + Forminator
5. Follow setup steps below

---

## Setup Checklist

### Step 1 — Homepage
- Settings → Reading → Your homepage displays → A static page → Homepage

### Step 2 — Forminator Form (IMPORTANT — read carefully)
1. Install & activate Forminator
2. Create a new form with these EXACT fields in this order:

| Field Label | Field Type | Field Name (check in settings) |
|-------------|-----------|-------------------------------|
| First Name | Single Line Text | `text-1` |
| Last Name | Single Line Text | `text-2` |
| Email Address | Email | **`email-1`** ← must be this |
| Phone Number | Phone | `phone-1` |
| Inquiry Type | Select | `select-1` |
| Message | Textarea | `textarea-1` |

**Inquiry Type dropdown values:**
```
General Inquiry
Personal Guidance
Women's Work
Conscious Leadership
Other
```

3. Note the form's **ID number** (visible in Forms list)
4. Go to: **WP Admin → Site Settings → Contact Section → Forminator Form ID**
5. Enter the form ID — the form appears automatically

> ⚠️ The email field MUST be named `email-1` for Phase 2 returning visitor detection to work.
> If you rename it, update `SK_EMAIL_FIELD` in functions.php accordingly.

### Step 3 — Hero Image
- **WP Admin → Site Settings → Hero → Hero Image**
- Recommended: 900×1200px minimum, atmospheric quality

### Step 4 — Hero Text
- All hero stages editable under **Site Settings → Hero**

### Step 5 — Offerings
- Homepage edit → **Offerings** (ACF repeater)
- Up to 8 offerings: Image, Tag, Title, Description, Price

### Step 6 — FAQ Items
- Homepage edit → **FAQs** (ACF repeater)

### Step 7 — Founder Photos
- **Site Settings → Founder Photos**
- Min 520×700px portraits for Kalai and Christophe

### Step 8 — Footer / Contact Info
- **Site Settings → Footer & Social**
- Email, Phone, Instagram URL, Facebook URL, WhatsApp link
- WhatsApp format: `https://wa.me/6512345678`

---

## Phase 2 — Returning Visitor Detection

### What it does
When a user submits the Forminator form:
- **New visitor** → success message: *"Your message has been received. We will connect with you soon."*
- **Returning visitor** (same email as a previous submission) → *"Welcome back — it's good to hear from you again. We'll reconnect with you shortly."*

### How it works
- The hook `forminator_custom_form_success_message` fires after each submission.
- It queries `{prefix}_frmt_form_entry_meta` for the submitted email.
- If count > 1 (email was seen before), the returning message is shown.
- No cookies. No creepy tracking. Email-based only.
- The visitor never sees their submission count. Just a warm acknowledgement.

### Configuration
The email field name is set via the constant in `functions.php`:
```php
define( 'SK_EMAIL_FIELD', 'email-1' );
```
Update this if you rename your Forminator email field.

---

## Google Sheets CRM Structure

When connecting via Make (Integromat), map your sheet columns in this exact order:

| # | Column | Source | Notes |
|---|--------|--------|-------|
| A | Timestamp | Make auto | Date/time of submission |
| B | Full Name | Formula | `=CONCAT(C2," ",D2)` |
| C | First Name | Form field `text-1` | |
| D | Last Name | Form field `text-2` | |
| E | Email | Form field `email-1` | Primary key |
| F | Phone | Form field `phone-1` | |
| G | Inquiry Type | Form field `select-1` | |
| H | Message | Form field `textarea-1` | |
| I | Source | Static: "Website" | |
| J | Status | Manual dropdown | New / Contacted / In Conversation / Closed |
| K | Notes | Manual | Internal notes |
| L | Follow Up Date | Manual | |
| M | Duplicate Status | Formula | `=IF(COUNTIF($E$2:E2,E2)>1,"Duplicate","New")` |
| N | Lead Count | Formula | `=COUNTIF($E:$E,E2)` |

### Make.com Automation Flow
```
Forminator → Webhook → Google Sheets (Add Row)
```

1. In Make: Create a new scenario
2. Trigger: Forminator webhook (or use Forminator's built-in webhook setting)
3. Action: Google Sheets → Add a Row
4. Map each field to the correct column

### Conditional Formatting in Google Sheets
- **Status = New** → Yellow fill
- **Status = Contacted** → Light blue fill
- **Status = Closed** → Light green fill
- **Duplicate Status = Duplicate** → Light orange fill (column M)

---

## ACF Fields Reference

### Options Page (Site Settings)

| Field Name | Type | Used In |
|-----------|------|--------|
| `hero_image` | Image | Hero right panel |
| `hero_stage1` | Text | Hero — chaos line |
| `hero_stage2a` / `hero_stage2b` | Text | Hero — turning lines |
| `hero_stage3a` / `hero_stage3b` | Text | Hero — calm lines |
| `hero_sub` | Textarea | Hero — sub paragraph |
| `hero_cta1_text` / `hero_cta1_url` | Text/URL | Hero — primary CTA |
| `hero_cta2_text` / `hero_cta2_url` | Text/URL | Hero — secondary CTA |
| `cta_eyebrow` | Text | Contact section eyebrow |
| `cta_heading` | WYSIWYG | Contact section heading |
| `cta_sub` | Textarea | Contact section sub |
| `forminator_form_id` | Number | Contact section form |
| `footer_email` | Email | Footer + CTA section |
| `footer_phone` | Text | Footer + CTA section |
| `social_instagram` | URL | Footer |
| `social_facebook` | URL | Footer |
| `social_whatsapp` | URL | CTA section + footer |
| `founder_image_kalai` | Image | Founders section |
| `founder_image_christophe` | Image | Founders section |

---

## Section Anchors (Single Page)
| Section | Anchor | Nav Link |
|--------|--------|---------| 
| Hero | — | Logo |
| About | `#about` | About |
| Offerings | `#offerings` | Offerings |
| Founders | `#founders` | Founders |
| FAQ | `#faq` | FAQ |
| Contact | `#contact` | Book a Call |

---

## Changelog

### v4.0.0
- **New**: Phase 2 returning visitor detection — `forminator_custom_form_success_message` filter
- **New**: New vs returning user success messages (email-based, no cookies)
- **New**: `SK_EMAIL_FIELD` constant for easy field name configuration
- **Updated**: README with full Google Sheets CRM column structure + Make.com flow
- **Updated**: ACF Forminator Form ID field instructions updated with field name requirements
- **Updated**: Version bump across all assets

### v3.0.0
- New: Spiritual/angelic/celestial aesthetic layer — golden orb effects, star-field, divine light gradients
- New: Editorial split hero — narrative left, parallax image right
- New: Scroll progress bar (gold→terra gradient)
- New: Mobile hamburger menu with full-screen overlay
- New: ACF hero text fields (all stages, CTAs editable)
- New: ACF FAQ repeater
- New: ACF Offerings with image field
- New: Forminator form embedded in-page (split layout)
- New: Single-page navigation — all CTAs link to `#contact`
