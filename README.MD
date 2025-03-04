# Bitrix24 CRM Entity Export

This module allows you to export contacts from Bitrix24 CRM into CSV or XLSX formats.

---

## Installation

1. **Clone or Download the Module**:
    - Place the module folder under `/local/modules/khork.crmentityexport/`.

2. **Install the Module**:
    - Go to **Bitrix24 Admin Panel** → **Marketplace** → **Installed Solutions**.
    - Find the **CRM Entity Export** module and click **Install**.

3. **Install Dependencies**:
    - Run composer install in module folder:
      ```bash
      composer install
      ```

---

## Usage

### Exporting Contacts

1. **Navigate to Contacts Page**:
    - Go to **CRM** → **Contacts**

2. **Click Export Button**:
    - Click the **Export Contacts** button in filter toolbar.

3. **Choose Format**:
    - Select either **CSV** or **XLSX** format in the popup.

4. **Download File**:
    - Click Ok and file will be downloaded automatically.

---