<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
/**
 * MediOrbit - Personal Health Analyzer (View 1)
 * 
 * Replicates the clean, clinical, and premium aesthetics of the
 * MediCompass design system.
 */

require_once __DIR__ . '/config/db.php';

// Always reset to default unselected state on page refresh/start
$_SESSION['active_condition'] = [
    'id' => null,
    'name' => 'Healthy Person',
    'target_kcal' => 2000
];
$active_condition = $_SESSION['active_condition'];

// Fetch 12 health conditions from database
$conditions = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM health_conditions ORDER BY id ASC");
    $conditions = $stmt->fetchAll();
} catch (Exception $e) {
    // Graceful fallback for initial loading before database setup
    $conditions = [
        ['id' => 1, 'condition_name' => 'Organ Strain', 'target_kcal' => 1200],
        ['id' => 2, 'condition_name' => 'Metabolic Stress', 'target_kcal' => 1300],
        ['id' => 3, 'condition_name' => 'Heartburn', 'target_kcal' => 1300],
        ['id' => 4, 'condition_name' => 'Bloating', 'target_kcal' => 1400],
        ['id' => 5, 'condition_name' => 'Abdominal Discomfort', 'target_kcal' => 1300],
        ['id' => 6, 'condition_name' => 'Type 2 Diabetes', 'target_kcal' => 1200],
        ['id' => 7, 'condition_name' => 'Hypertension', 'target_kcal' => 1400],
        ['id' => 8, 'condition_name' => 'High Cholesterol', 'target_kcal' => 1300],
        ['id' => 9, 'condition_name' => 'Fatty Liver Disease', 'target_kcal' => 1550],
        ['id' => 10, 'condition_name' => 'Weight Gain', 'target_kcal' => 1400],
        ['id' => 11, 'condition_name' => 'Obesity', 'target_kcal' => 1500],
        ['id' => 12, 'condition_name' => 'Heart Disease', 'target_kcal' => 1400]
    ];
}

include_once __DIR__ . '/includes/navbar.php';
?>

<main class="py-5" style="background-color: var(--bg-analyzer);">
    <div class="container container-desktop">
        
        <!-- 1. Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="clinical-heading mb-3" style="font-size: 38px;">Personal Health Analyzer</h1>
                <p class="clinical-subtext mx-auto" style="max-width: 650px;">
                    Precision-driven clinical analysis for your metabolic health. Select your primary health focus to begin calibration.
                </p>
            </div>
        </div>

        <!-- 2. Interactive Health Problem Selector Grid -->
        <div class="row g-3 mb-4">
            <?php foreach ($conditions as $cond): ?>
                <?php 
                $isActive = ($active_condition['name'] === $cond['condition_name']) ? 'active' : '';
                ?>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="condition-card <?php echo $isActive; ?>" 
                         data-id="<?php echo $cond['id']; ?>" 
                         data-name="<?php echo $cond['condition_name']; ?>" 
                         data-kcal="<?php echo $cond['target_kcal']; ?>">
                        <?php echo htmlspecialchars($cond['condition_name']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 3. Calorie Calibration Banner -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="calibration-bar p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="m-0 fw-bold" style="font-family: var(--font-sans);">Calorie Calibration</h4>
                        <p id="calibrationLabelText" class="m-0 mt-1 opacity-75" style="font-size: 13px;">
                            <?php 
                            if ($active_condition['name'] === 'Healthy Person') {
                                echo "Standard Target for Healthy Individual";
                            } else {
                                echo "Personalized Target for " . htmlspecialchars($active_condition['name']);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="text-end">
                        <div class="calibration-kcal-label">
                            <span id="targetCalorieDisplay"><?php echo $active_condition['target_kcal']; ?></span>
                            <span style="font-size: 14px; font-weight: 500; opacity: 0.8;">kcal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Two-Column Split Layout -->
        <div class="row g-4 mb-5">
            
            <!-- Left Column: Meal Image Drag-and-Drop & Action -->
            <div class="col-lg-5">
                <div class="upload-container-card p-4 h-100 d-flex flex-column">
                    <h5 class="fw-bold mb-3" style="color: #1b3322; font-family: var(--font-sans);">
                        <i class="fa-solid fa-camera me-2"></i> Food Dish Analyzer
                    </h5>
                    
                    <!-- Drag and Drop Box -->
                    <div class="upload-zone flex-grow-1 mb-3" id="uploadZone">
                        <div class="golden-scan-line" id="goldenScan"></div>
                        <!-- Loading spinner -->
                        <div class="loading-overlay" id="loadingOverlay">
                            <div class="clinical-spinner mb-3"></div>
                            <span class="fw-semibold text-dark" style="font-size: 14px;">Analyzing Meal...</span>
                        </div>
                        
                        <div class="upload-helper-content text-center py-4" id="uploadHelperContent">
                            <i class="fa-solid fa-camera upload-icon mb-3"></i>
                            <h6 class="fw-semibold text-dark mb-3">Upload Food Image</h6>
                            <div class="d-flex justify-content-center gap-3">
                                <button type="button" class="btn btn-outline-dark upload-btn" id="btnCameraUpload" style="border-radius: 8px;">
                                    <i class="fa-solid fa-camera me-1"></i> Camera
                                </button>
                                <button type="button" class="btn btn-outline-dark upload-btn" id="btnGalleryUpload" style="border-radius: 8px;">
                                    <i class="fa-regular fa-images me-1"></i> Gallery
                                </button>
                            </div>
                        </div>
                        
                        <input type="file" id="cameraInput" accept="image/*" capture="camera" style="display: none;">
                        <input type="file" id="galleryInput" accept="image/*" style="display: none;">
                    </div>
                    
                    <!-- green Action button -->
                    <button class="btn btn-analyze w-100 py-3" id="analyzeBtn" disabled>
                        <i class="fa-solid fa-square-poll-vertical me-2"></i> Analyze Meal
                    </button>
                </div>
            </div>

            <!-- Right Column: Nutritional Breakdown & Remaining allowance -->
            <div class="col-lg-7">
                <div class="d-flex flex-column h-100 justify-content-between">
                    
                    <!-- Nutritional Breakdown Header Callout -->
                    <div class="analysis-result-header p-4 d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-uppercase opacity-75 fw-bold" style="font-size: 10px; letter-spacing: 1px;">Total Food Kcal</span>
                            <h4 class="m-0 fw-bold" style="font-family: var(--font-sans);">Analysis Result</h4>
                        </div>
                        <div class="text-end">
                            <div style="font-size: 40px; font-weight: 700; line-height: 1;">
                                <span id="analyzedKcalDisplay">0</span>
                                <span style="font-size: 14px; font-weight: 500; opacity: 0.8;">kcal</span>
                            </div>
                        </div>
                    </div>

                    <!-- Macro & Micro Tiles Grid -->
                    <div class="row g-3 mb-3">
                        <!-- 1. Protein -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Protein</span>
                                <div class="nutrient-tile-value"><span id="tile_protein">0</span>g</div>
                            </div>
                        </div>
                        <!-- 2. Fats -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Fats</span>
                                <div class="nutrient-tile-value"><span id="tile_fats">0</span>g</div>
                            </div>
                        </div>
                        <!-- 3. Sodium -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Sodium</span>
                                <div class="nutrient-tile-value" id="tile_sodium">0.0g</div>
                            </div>
                        </div>
                        <!-- 4. Carbohydrates -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Carbs</span>
                                <div class="nutrient-tile-value"><span id="tile_carbs">0</span>g</div>
                            </div>
                        </div>
                        <!-- 5. Oil -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Oil</span>
                                <div class="nutrient-tile-value"><span id="tile_oil">0</span>ml</div>
                            </div>
                        </div>
                        <!-- 6. Cholesterol -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Cholesterol</span>
                                <div class="nutrient-tile-value"><span id="tile_cholesterol">0</span>mg</div>
                            </div>
                        </div>
                        <!-- 7. Sugar -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Sugar</span>
                                <div class="nutrient-tile-value"><span id="tile_sugar">0</span>g</div>
                            </div>
                        </div>
                        <!-- 8. Fiber -->
                        <div class="col-md-3 col-6">
                            <div class="nutrient-grid-tile">
                                <span class="nutrient-tile-label">Fiber</span>
                                <div class="nutrient-tile-value" id="tile_fiber">0.0g</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kcal Allowance Calculation Blue Dashboard -->
                    <div class="allowance-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #1d3557; font-family: var(--font-sans);">Kcal Allowance Calculation</h5>
                                <div id="formulaDisplay" class="allowance-formula-box">
                                    Target <?php echo $active_condition['target_kcal']; ?> - Food 0 = Remaining
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="allowance-remaining-title">Remaining Today</span>
                                <div class="allowance-remaining-kcal">
                                    <span id="remainingKcalDisplay"><?php echo $active_condition['target_kcal']; ?></span>
                                    <span style="font-size: 14px; font-weight: 500;">kcal</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress bar -->
                        <div class="allowance-progress-wrapper">
                            <div class="allowance-progress-bar" id="allowanceProgressBar"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- 5. AI Treatment Bot & Health Risk Alert Banner -->
        <div class="row">
            <div class="col-12">
                <div class="risk-alert-banner p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center w-100" id="riskAlertBanner" style="background-color: #ffffff; border-color: #e2e8f0; width: 100%;">
                    <div class="d-flex align-items-start align-items-md-center flex-grow-1 mb-3 mb-md-0" style="min-width: 0; width: 100%;">
                        <div class="risk-alert-icon me-4 flex-shrink-0 mt-1 mt-md-0">
                            <i class="fa-solid fa-circle-info" style="color: #6c757d;"></i>
                        </div>
                        <div style="flex: 1 1 auto; min-width: 0; width: 100%; max-width: 100%; word-wrap: break-word; overflow-wrap: break-word;">
                            <div class="d-flex align-items-center mb-1">
                                <h5 class="risk-alert-title m-0 me-3" style="color: #495057;">Health Risk Alert</h5>
                                <button class="btn btn-translate d-flex align-items-center" id="aiTranslateBtn">
                                    <i class="fa-solid fa-language me-1"></i> <span id="aiTranslateBtnText">Translate to Urdu</span>
                                </button>
                            </div>
                            <div class="risk-alert-desc m-0" id="aiAlertDescription" style="color: #6c757d; word-wrap: break-word; white-space: normal; line-height: 1.6; width: 100%; display: block;">
                                System Ready. Awaiting image upload to perform AI food analysis.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Suggested portion Badge -->
                    <div class="serving-suggestion-card ms-4 flex-shrink-0">
                        <span class="serving-label">Suggested Serving</span>
                        <div class="serving-value" id="aiSuggestedServing">-</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Webcam Capture Modal -->
<div class="modal fade" id="webcamModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-custom">
      <div class="modal-header modal-header-custom border-bottom-0 pb-0">
        <h5 class="modal-title clinical-heading" style="font-size: 20px;">Take Meal Photo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeWebcamBtn"></button>
      </div>
      <div class="modal-body text-center pt-3">
        <div style="position: relative; background: #000; border-radius: 12px; overflow: hidden;">
            <video id="webcamVideo" autoplay playsinline style="width: 100%; max-height: 350px; object-fit: cover;"></video>
            <div id="webcamErrorMsg" class="text-white p-3" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%;">
                Camera access denied or not available.
            </div>
        </div>
        <canvas id="webcamCanvas" style="display:none;"></canvas>
      </div>
      <div class="modal-footer modal-footer-custom border-top-0 pt-0 justify-content-center">
        <button type="button" class="btn btn-analyze rounded-pill px-5" id="captureWebcamBtn">
            <i class="fa-solid fa-camera me-2"></i> Capture Image
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Set Initial JS Target values dynamically from PHP Session -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        MediState.targetKcal = <?php echo $active_condition['target_kcal']; ?>;
        MediState.remainingKcal = <?php echo $active_condition['target_kcal']; ?>;
        MediState.activeConditionName = "<?php echo addslashes($active_condition['name']); ?>";
    });
</script>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
