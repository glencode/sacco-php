<?php
/**
 * Template Name: Mortgage Calculator
 *
 * This template is used for the mortgage calculator page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="page-header bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="calculator-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">Mortgage Calculator</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form id="mortgage-calculator-form" class="mortgage-form">
                                        <div class="mb-3">
                                            <label for="property-value" class="form-label">Property Value (KSh)</label>
                                            <input type="number" class="form-control" id="property-value" min="100000" step="100000" value="5000000" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="down-payment" class="form-label">Down Payment (KSh)</label>
                                            <input type="number" class="form-control" id="down-payment" min="0" step="100000" value="1000000" required>
                                            <div class="form-text" id="down-payment-percent">20% of property value</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mortgage-amount" class="form-label">Mortgage Amount (KSh)</label>
                                            <input type="number" class="form-control" id="mortgage-amount" readonly value="4000000">
                                        </div>
                                        <div class="mb-3">
                                            <label for="interest-rate" class="form-label">Interest Rate (% per year)</label>
                                            <input type="number" class="form-control" id="interest-rate" min="1" max="30" step="0.1" value="10.5" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mortgage-term" class="form-label">Mortgage Term (Years)</label>
                                            <select class="form-select" id="mortgage-term">
                                                <option value="5">5 years</option>
                                                <option value="10">10 years</option>
                                                <option value="15">15 years</option>
                                                <option value="20">20 years</option>
                                                <option value="25" selected>25 years</option>
                                                <option value="30">30 years</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" id="calculate-btn" class="btn btn-primary w-100">Calculate</button>
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" id="print-btn" class="btn btn-outline-secondary w-100">Print Results</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="results-container">
                                        <h4 class="text-center mb-4">Mortgage Summary</h4>
                                        <div class="result-item d-flex justify-content-between">
                                            <span>Monthly Payment:</span>
                                            <strong id="monthly-payment">KSh 0</strong>
                                        </div>
                                        <div class="result-item d-flex justify-content-between">
                                            <span>Total Payment:</span>
                                            <strong id="total-payment">KSh 0</strong>
                                        </div>
                                        <div class="result-item d-flex justify-content-between">
                                            <span>Total Interest:</span>
                                            <strong id="total-interest">KSh 0</strong>
                                        </div>
                                        <div class="result-item d-flex justify-content-between">
                                            <span>Loan-to-Value Ratio:</span>
                                            <strong id="ltv-ratio">0%</strong>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <canvas id="payment-chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-5">
                                <div class="col-12">
                                    <h4>Amortization Schedule</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="amortization-table">
                                            <thead>
                                                <tr>
                                                    <th>Year</th>
                                                    <th>Principal Paid</th>
                                                    <th>Interest Paid</th>
                                                    <th>Total Paid</th>
                                                    <th>Remaining Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Will be populated by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mortgage-info mt-5">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h4 class="mb-0">About Our Mortgage Products</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                // Display the page content
                                while (have_posts()) :
                                    the_post();
                                    the_content();
                                endwhile;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer(); 