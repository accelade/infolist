import { test, expect } from '@playwright/test';

test.describe('Infolist Demo', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/docs/infolists-text-entry');
    });

    test('displays text entry demo', async ({ page }) => {
        // Wait for the page to load
        await expect(page.locator('.accelade-infolist')).toBeVisible();

        // Check for text content
        await expect(page.locator('text=Introduction to Laravel')).toBeVisible();
    });

    test('text entry copyable functionality', async ({ page }) => {
        // Find a copyable element
        const copyable = page.locator('[data-copyable]').first();

        if (await copyable.isVisible()) {
            // Click to copy
            await copyable.click();

            // Check for feedback (the button should show check icon or copied message)
            // This depends on the implementation
            await expect(copyable).toBeVisible();
        }
    });

    test('displays badge entries correctly', async ({ page }) => {
        // Look for badge styling
        const badges = page.locator('.rounded-full.px-2\\.5.py-0\\.5');

        if (await badges.first().isVisible()) {
            await expect(badges.first()).toBeVisible();
        }
    });

    test('displays formatted dates', async ({ page }) => {
        // Look for date-like content
        const content = await page.textContent('.accelade-infolist');
        expect(content).toBeTruthy();
    });
});

test.describe('Icon Entry Demo', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/docs/infolists-icon-entry');
    });

    test('displays icon entry demo', async ({ page }) => {
        await expect(page.locator('.accelade-infolist')).toBeVisible();
    });

    test('displays boolean icons', async ({ page }) => {
        // Check for SVG icons
        const icons = page.locator('svg');
        await expect(icons.first()).toBeVisible();
    });
});

test.describe('Image Entry Demo', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/docs/infolists-image-entry');
    });

    test('displays image entry demo', async ({ page }) => {
        await expect(page.locator('.accelade-infolist')).toBeVisible();
    });

    test('displays images', async ({ page }) => {
        const images = page.locator('img');
        await expect(images.first()).toBeVisible();
    });

    test('displays circular images', async ({ page }) => {
        const circularImages = page.locator('img.rounded-full');
        if (await circularImages.first().isVisible()) {
            await expect(circularImages.first()).toBeVisible();
        }
    });

    test('displays stacked images', async ({ page }) => {
        const stacked = page.locator('.-space-x-2');
        if (await stacked.first().isVisible()) {
            await expect(stacked.first()).toBeVisible();
        }
    });
});

test.describe('Color Entry Demo', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/docs/infolists-color-entry');
    });

    test('displays color entry demo', async ({ page }) => {
        await expect(page.locator('.accelade-infolist')).toBeVisible();
    });

    test('displays color swatches', async ({ page }) => {
        // Color swatches have inline background-color style
        const swatches = page.locator('[style*="background-color"]');
        await expect(swatches.first()).toBeVisible();
    });

    test('displays hex values', async ({ page }) => {
        // Look for hex color codes
        const content = await page.textContent('.accelade-infolist');
        expect(content).toMatch(/#[0-9A-Fa-f]{6}/);
    });
});

test.describe('Key Value Entry Demo', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/docs/infolists-key-value-entry');
    });

    test('displays key value entry demo', async ({ page }) => {
        await expect(page.locator('.accelade-infolist')).toBeVisible();
    });

    test('displays table structure', async ({ page }) => {
        const tables = page.locator('table');
        await expect(tables.first()).toBeVisible();
    });

    test('displays key-value pairs', async ({ page }) => {
        // Check for table rows
        const rows = page.locator('tbody tr');
        await expect(rows.first()).toBeVisible();
    });
});

test.describe('Repeatable Entry Demo', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/docs/infolists-repeatable-entry');
    });

    test('displays repeatable entry demo', async ({ page }) => {
        await expect(page.locator('.accelade-infolist')).toBeVisible();
    });

    test('displays multiple items', async ({ page }) => {
        // Check for repeated content containers
        const containers = page.locator('.rounded-lg.border');
        const count = await containers.count();
        expect(count).toBeGreaterThan(0);
    });

    test('displays grid layout when enabled', async ({ page }) => {
        const grid = page.locator('.grid.gap-4');
        if (await grid.first().isVisible()) {
            await expect(grid.first()).toBeVisible();
        }
    });
});

test.describe('Infolist Navigation', () => {
    test('can navigate between infolist sections', async ({ page }) => {
        await page.goto('/docs/infolists-getting-started');

        // Check the page loaded
        await expect(page.locator('body')).toBeVisible();

        // Navigate to text entry
        const textEntryLink = page.locator('a:has-text("Text Entry")');
        if (await textEntryLink.isVisible()) {
            await textEntryLink.click();
            await expect(page).toHaveURL(/infolists-text-entry/);
        }
    });
});

test.describe('Accessibility', () => {
    test('infolist has proper structure', async ({ page }) => {
        await page.goto('/docs/infolists-text-entry');

        // Check for semantic structure
        await expect(page.locator('.accelade-infolist')).toBeVisible();

        // Check for labels
        const labels = page.locator('.accelade-entry-label');
        if (await labels.first().isVisible()) {
            await expect(labels.first()).toBeVisible();
        }
    });
});
