<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Sobreposição Mobile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        
        .test-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
        }
        
        /* Header Original */
        .header-original {
            background: #6366f1;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 100;
        }
        
        /* Header Fix 1 - Relative */
        .header-fix1 {
            background: #10b981;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }
        
        /* Header Fix 2 - Sticky */
        .header-fix2 {
            background: #f59e0b;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        /* Header Fix 3 - Fixed */
        .header-fix3 {
            background: #ef4444;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .content-fix3 {
            padding-top: 80px;
        }
        
        /* Cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }
        
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card:first-child {
            background: #fef3c7;
            border-color: #f59e0b;
        }
        
        .card h3 {
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .card p {
            color: #6b7280;
        }
        
        /* Debug Info */
        .debug-panel {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 15px;
            border-radius: 8px;
            font-size: 12px;
            max-width: 250px;
            z-index: 10000;
        }
        
        .debug-panel h3 {
            margin-bottom: 10px;
            color: #fbbf24;
        }
        
        .debug-panel p {
            margin: 5px 0;
            font-family: monospace;
        }
        
        /* Controls */
        .controls {
            position: fixed;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.9);
            color: white;
            padding: 15px;
            border-radius: 8px;
            z-index: 10000;
        }
        
        .controls button {
            display: block;
            width: 100%;
            margin: 5px 0;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .btn-original { background: #6366f1; color: white; }
        .btn-fix1 { background: #10b981; color: white; }
        .btn-fix2 { background: #f59e0b; color: white; }
        .btn-fix3 { background: #ef4444; color: white; }
        .btn-reset { background: #6b7280; color: white; }
        
        /* Mobile specific */
        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
                padding: 0.5rem;
            }
            
            .card {
                margin-bottom: 1rem;
            }
            
            .card:first-child {
                margin-top: 1rem;
            }
        }
        
        /* Highlight overlap */
        .highlight-overlap .card:first-child {
            border: 3px solid red;
            background: rgba(255,0,0,0.1);
        }
        
        .highlight-overlap .header-original,
        .highlight-overlap .header-fix1,
        .highlight-overlap .header-fix2,
        .highlight-overlap .header-fix3 {
            border: 3px solid blue;
            background: rgba(0,0,255,0.1);
        }
    </style>
</head>
<body>
    <!-- Debug Panel -->
    <div class="debug-panel">
        <h3>🔍 Debug Mobile</h3>
        <p><strong>Viewport:</strong> <span id="viewport"></span></p>
        <p><strong>Header Height:</strong> <span id="header-height"></span></p>
        <p><strong>First Card Top:</strong> <span id="card-top"></span></p>
        <p><strong>Overlap:</strong> <span id="overlap"></span></p>
        <p><strong>Current Fix:</strong> <span id="current-fix"></span></p>
    </div>
    
    <!-- Controls -->
    <div class="controls">
        <h3>🎛️ Testes</h3>
        <button class="btn-original" onclick="testOriginal()">Original</button>
        <button class="btn-fix1" onclick="testFix1()">Fix 1: Relative</button>
        <button class="btn-fix2" onclick="testFix2()">Fix 2: Sticky</button>
        <button class="btn-fix3" onclick="testFix3()">Fix 3: Fixed</button>
        <button class="btn-reset" onclick="resetTest()">Reset</button>
        <button onclick="toggleHighlight()">🔍 Highlight</button>
    </div>

    <!-- Test Original -->
    <div id="test-original" class="test-container">
        <header class="header-original">
            <h1>Header Original (Relative, z-index: 100)</h1>
            <span>Menu</span>
        </header>
        <div class="cards-grid">
            <div class="card">
                <h3>Primeiro Card</h3>
                <p>Este card pode estar sendo sobreposto pelo header no mobile.</p>
            </div>
            <div class="card">
                <h3>Segundo Card</h3>
                <p>Card normal.</p>
            </div>
            <div class="card">
                <h3>Terceiro Card</h3>
                <p>Card normal.</p>
            </div>
        </div>
    </div>

    <!-- Test Fix 1 -->
    <div id="test-fix1" class="test-container" style="display: none;">
        <header class="header-fix1">
            <h1>Header Fix 1 (Relative, z-index: 10)</h1>
            <span>Menu</span>
        </header>
        <div class="cards-grid">
            <div class="card">
                <h3>Primeiro Card</h3>
                <p>Header com z-index menor.</p>
            </div>
            <div class="card">
                <h3>Segundo Card</h3>
                <p>Card normal.</p>
            </div>
            <div class="card">
                <h3>Terceiro Card</h3>
                <p>Card normal.</p>
            </div>
        </div>
    </div>

    <!-- Test Fix 2 -->
    <div id="test-fix2" class="test-container" style="display: none;">
        <header class="header-fix2">
            <h1>Header Fix 2 (Sticky, z-index: 100)</h1>
            <span>Menu</span>
        </header>
        <div class="cards-grid">
            <div class="card">
                <h3>Primeiro Card</h3>
                <p>Header sticky no topo.</p>
            </div>
            <div class="card">
                <h3>Segundo Card</h3>
                <p>Card normal.</p>
            </div>
            <div class="card">
                <h3>Terceiro Card</h3>
                <p>Card normal.</p>
            </div>
        </div>
    </div>

    <!-- Test Fix 3 -->
    <div id="test-fix3" class="test-container" style="display: none;">
        <header class="header-fix3">
            <h1>Header Fix 3 (Fixed, z-index: 1000)</h1>
            <span>Menu</span>
        </header>
        <div class="cards-grid content-fix3">
            <div class="card">
                <h3>Primeiro Card</h3>
                <p>Header fixo com padding-top no conteúdo.</p>
            </div>
            <div class="card">
                <h3>Segundo Card</h3>
                <p>Card normal.</p>
            </div>
            <div class="card">
                <h3>Terceiro Card</h3>
                <p>Card normal.</p>
            </div>
        </div>
    </div>

    <script>
        function updateDebugInfo() {
            const viewport = `${window.innerWidth}x${window.innerHeight}`;
            const header = document.querySelector('header');
            const firstCard = document.querySelector('.card:first-child');
            
            const headerHeight = header ? header.offsetHeight : 0;
            const cardTop = firstCard ? firstCard.offsetTop : 0;
            const overlap = cardTop < headerHeight ? 'SIM' : 'NÃO';
            
            const currentFix = document.querySelector('.test-container[style*="display: block"]') || 
                              document.querySelector('.test-container:not([style*="display: none"])');
            const fixName = currentFix ? currentFix.id.replace('test-', '') : 'original';
            
            document.getElementById('viewport').textContent = viewport;
            document.getElementById('header-height').textContent = headerHeight + 'px';
            document.getElementById('card-top').textContent = cardTop + 'px';
            document.getElementById('overlap').textContent = overlap;
            document.getElementById('current-fix').textContent = fixName;
        }
        
        function showTest(testId) {
            // Hide all tests
            document.querySelectorAll('.test-container').forEach(container => {
                container.style.display = 'none';
            });
            
            // Show selected test
            document.getElementById(testId).style.display = 'block';
            
            updateDebugInfo();
        }
        
        function testOriginal() {
            showTest('test-original');
        }
        
        function testFix1() {
            showTest('test-fix1');
        }
        
        function testFix2() {
            showTest('test-fix2');
        }
        
        function testFix3() {
            showTest('test-fix3');
        }
        
        function resetTest() {
            showTest('test-original');
            document.body.classList.remove('highlight-overlap');
        }
        
        function toggleHighlight() {
            document.body.classList.toggle('highlight-overlap');
        }
        
        // Initialize
        window.addEventListener('load', updateDebugInfo);
        window.addEventListener('resize', updateDebugInfo);
        setInterval(updateDebugInfo, 1000);
        
        // Show original by default
        testOriginal();
    </script>
</body>
</html> 