/**
 * Daystar Multi-Purpose Co-op Society - Asset Integration Test
 *
 * This file tests the integration of all CSS and JS files
 */

// Function to test if CSS files are properly loaded
function testCSSIntegration() {
  console.log('Testing CSS integration...');
  
  // Get all linked stylesheets
  const stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
  const styleElements = document.querySelectorAll('style');
  
  console.log(`Found ${stylesheets.length} linked stylesheets and ${styleElements.length} style elements`);
  
  // Check if main CSS file is loaded
  const mainCSSLoaded = Array.from(stylesheets).some(link => 
    link.href.includes('main.css') || link.href.includes('style.css')
  );
  
  console.log(`Main CSS file loaded: ${mainCSSLoaded}`);
  
  // Test if CSS variables are accessible
  const testElement = document.createElement('div');
  testElement.style.display = 'none';
  document.body.appendChild(testElement);
  
  // Get computed styles
  const styles = window.getComputedStyle(testElement);
  const primaryColor = styles.getPropertyValue('--primary-color').trim();
  const fontFamily = styles.getPropertyValue('--font-family-base').trim();
  
  console.log(`CSS Variables accessible: ${!!primaryColor || !!fontFamily}`);
  console.log(`Primary color: ${primaryColor || 'Not found'}`);
  console.log(`Font family: ${fontFamily || 'Not found'}`);
  
  // Clean up
  document.body.removeChild(testElement);
  
  return {
    totalStylesheets: stylesheets.length,
    mainCSSLoaded: mainCSSLoaded,
    cssVariablesAccessible: !!primaryColor || !!fontFamily
  };
}

// Function to test if JS files are properly loaded
function testJSIntegration() {
  console.log('Testing JS integration...');
  
  // Check for core functions
  const coreJSLoaded = typeof initNavigation === 'function' || 
                       typeof initDropdowns === 'function' || 
                       typeof initForms === 'function';
  
  console.log(`Core JS functions loaded: ${coreJSLoaded}`);
  
  // Check for component functions
  const authJSLoaded = typeof initAuthentication === 'function' || 
                       typeof initLoginForm === 'function' || 
                       typeof initRegistrationForm === 'function';
  
  console.log(`Authentication JS functions loaded: ${authJSLoaded}`);
  
  const calculatorJSLoaded = typeof initLoanCalculators === 'function' || 
                             typeof initStandardLoanCalculator === 'function';
  
  console.log(`Loan Calculator JS functions loaded: ${calculatorJSLoaded}`);
  
  const dashboardJSLoaded = typeof initMemberDashboard === 'function';
  
  console.log(`Member Dashboard JS functions loaded: ${dashboardJSLoaded}`);
  
  const mpesaJSLoaded = typeof initMpesaPayment === 'function';
  
  console.log(`M-Pesa Payment JS functions loaded: ${mpesaJSLoaded}`);
  
  return {
    coreJSLoaded: coreJSLoaded,
    authJSLoaded: authJSLoaded,
    calculatorJSLoaded: calculatorJSLoaded,
    dashboardJSLoaded: dashboardJSLoaded,
    mpesaJSLoaded: mpesaJSLoaded
  };
}

// Function to test component rendering
function testComponentRendering() {
  console.log('Testing component rendering...');
  
  // Create test container
  const testContainer = document.createElement('div');
  testContainer.id = 'component-test-container';
  testContainer.style.display = 'none';
  document.body.appendChild(testContainer);
  
  // Test button rendering
  testContainer.innerHTML = `
    <button class="btn btn-primary">Primary Button</button>
    <button class="btn btn-secondary">Secondary Button</button>
    <button class="btn btn-success">Success Button</button>
  `;
  
  const buttons = testContainer.querySelectorAll('.btn');
  console.log(`Button components rendered: ${buttons.length === 3}`);
  
  // Test form rendering
  testContainer.innerHTML = `
    <form class="needs-validation">
      <div class="form-group">
        <label for="test-input">Test Input</label>
        <input type="text" class="form-control" id="test-input" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  `;
  
  const formControl = testContainer.querySelector('.form-control');
  console.log(`Form components rendered: ${!!formControl}`);
  
  // Test card rendering
  testContainer.innerHTML = `
    <div class="card">
      <div class="card-header">Card Header</div>
      <div class="card-body">
        <h5 class="card-title">Card Title</h5>
        <p class="card-text">Card text content.</p>
      </div>
      <div class="card-footer">Card Footer</div>
    </div>
  `;
  
  const card = testContainer.querySelector('.card');
  const cardBody = testContainer.querySelector('.card-body');
  console.log(`Card components rendered: ${!!card && !!cardBody}`);
  
  // Clean up
  document.body.removeChild(testContainer);
  
  return {
    buttonsRendered: buttons.length === 3,
    formRendered: !!formControl,
    cardRendered: !!card && !!cardBody
  };
}

// Run all tests when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('Running asset integration tests...');
  
  const cssResults = testCSSIntegration();
  const jsResults = testJSIntegration();
  const renderResults = testComponentRendering();
  
  console.log('Test results:', {
    css: cssResults,
    js: jsResults,
    rendering: renderResults
  });
  
  // Overall test status
  const cssSuccess = cssResults.mainCSSLoaded && cssResults.cssVariablesAccessible;
  const jsSuccess = jsResults.coreJSLoaded;
  const renderSuccess = renderResults.buttonsRendered && renderResults.formRendered && renderResults.cardRendered;
  
  const overallSuccess = cssSuccess && jsSuccess && renderSuccess;
  
  console.log(`Overall test status: ${overallSuccess ? 'PASSED' : 'FAILED'}`);
  
  // Display test results on page if in test mode
  if (window.location.search.includes('test=true')) {
    const resultContainer = document.createElement('div');
    resultContainer.className = 'test-results-container';
    resultContainer.style.padding = '20px';
    resultContainer.style.margin = '20px';
    resultContainer.style.border = '1px solid #ccc';
    resultContainer.style.borderRadius = '5px';
    
    resultContainer.innerHTML = `
      <h2>Asset Integration Test Results</h2>
      <h3>CSS Integration: ${cssSuccess ? '✅ PASSED' : '❌ FAILED'}</h3>
      <ul>
        <li>Stylesheets found: ${cssResults.totalStylesheets}</li>
        <li>Main CSS loaded: ${cssResults.mainCSSLoaded ? '✅' : '❌'}</li>
        <li>CSS Variables accessible: ${cssResults.cssVariablesAccessible ? '✅' : '❌'}</li>
      </ul>
      
      <h3>JS Integration: ${jsSuccess ? '✅ PASSED' : '❌ FAILED'}</h3>
      <ul>
        <li>Core JS loaded: ${jsResults.coreJSLoaded ? '✅' : '❌'}</li>
        <li>Authentication JS loaded: ${jsResults.authJSLoaded ? '✅' : '❌'}</li>
        <li>Loan Calculator JS loaded: ${jsResults.calculatorJSLoaded ? '✅' : '❌'}</li>
        <li>Member Dashboard JS loaded: ${jsResults.dashboardJSLoaded ? '✅' : '❌'}</li>
        <li>M-Pesa Payment JS loaded: ${jsResults.mpesaJSLoaded ? '✅' : '❌'}</li>
      </ul>
      
      <h3>Component Rendering: ${renderSuccess ? '✅ PASSED' : '❌ FAILED'}</h3>
      <ul>
        <li>Button components: ${renderResults.buttonsRendered ? '✅' : '❌'}</li>
        <li>Form components: ${renderResults.formRendered ? '✅' : '❌'}</li>
        <li>Card components: ${renderResults.cardRendered ? '✅' : '❌'}</li>
      </ul>
      
      <h3>Overall Status: ${overallSuccess ? '✅ PASSED' : '❌ FAILED'}</h3>
    `;
    
    document.body.prepend(resultContainer);
  }
});
