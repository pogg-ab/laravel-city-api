<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City API Explorer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b1021;
            --panel: #0f172a;
            --panel-alt: #111827;
            --accent: #5ef0c3;
            --accent-2: #f38ba0;
            --muted: #cbd5e1;
            --text: #e2e8f0;
            --card-border: #1f2937;
            --radius: 18px;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at 20% 20%, rgba(94, 240, 195, 0.12), transparent 35%),
                        radial-gradient(circle at 80% 0%, rgba(243, 139, 160, 0.12), transparent 32%),
                        radial-gradient(circle at 50% 80%, rgba(94, 240, 195, 0.12), transparent 30%),
                        var(--bg);
            color: var(--text);
            font-family: 'Space Grotesk', 'Manrope', system-ui, -apple-system, sans-serif;
            padding: 32px 20px 44px;
            display: flex;
            justify-content: center;
        }
        .page {
            width: min(1200px, 100%);
            display: grid;
            gap: 20px;
            grid-template-columns: 1.1fr 0.9fr;
        }
        @media (max-width: 960px) {
            .page { grid-template-columns: 1fr; }
        }
        .hero {
            position: relative;
            padding: 28px;
            border-radius: calc(var(--radius) + 6px);
            background: linear-gradient(120deg, rgba(94, 240, 195, 0.18), rgba(255, 255, 255, 0.02)), var(--panel);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow);
            overflow: hidden;
            isolation: isolate;
        }
        .hero::after {
            content: '';
            position: absolute;
            inset: -120px -80px auto auto;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(94, 240, 195, 0.38), transparent 45%);
            filter: blur(40px);
            opacity: 0.7;
            z-index: -1;
            transform: rotate(8deg);
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.03);
            color: var(--muted);
            font-size: 13px;
            letter-spacing: 0.01em;
        }
        .badge span {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(120deg, var(--accent), var(--accent-2));
            box-shadow: 0 0 0 6px rgba(94, 240, 195, 0.12);
        }
        h1 {
            margin: 18px 0 12px;
            font-size: clamp(32px, 5vw, 44px);
            letter-spacing: -0.02em;
        }
        .lead {
            margin: 0 0 18px;
            color: var(--muted);
            max-width: 640px;
            font-size: 16px;
            line-height: 1.6;
        }
        .cta-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }
        .btn {
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid transparent;
            font-weight: 600;
            cursor: pointer;
            color: #0b1021;
            background: linear-gradient(120deg, var(--accent), #8ff7d9);
            box-shadow: 0 10px 30px rgba(94, 240, 195, 0.25);
            transition: transform 160ms ease, box-shadow 160ms ease;
        }
        .btn.secondary {
            background: transparent;
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.14);
            box-shadow: none;
        }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .btn:not(:disabled):hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(94, 240, 195, 0.32); }
        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }
        .card {
            background: var(--panel-alt);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: var(--shadow);
        }
        .card h3 {
            margin: 0 0 10px;
            font-size: 15px;
            letter-spacing: 0.01em;
            color: var(--muted);
        }
        .stat-number {
            font-size: 28px;
            font-weight: 700;
        }
        .stat-note {
            color: var(--muted);
            font-size: 13px;
        }
        .endpoint-list {
            display: grid;
            gap: 10px;
        }
        .endpoint {
            display: grid;
            grid-template-columns: 90px 1fr 120px;
            gap: 10px;
            align-items: center;
            padding: 12px 14px;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.02);
        }
        .endpoint .verb {
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 10px;
            width: fit-content;
            background: rgba(94, 240, 195, 0.16);
            color: var(--accent);
        }
        .endpoint .path { font-family: 'Manrope', sans-serif; font-weight: 600; }
        .endpoint .note { color: var(--muted); font-size: 13px; text-align: right; }
        .panel {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: var(--shadow);
        }
        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }
        .panel-header h2 { margin: 0; font-size: 17px; letter-spacing: 0.01em; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        th, td {
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid var(--card-border);
            font-size: 14px;
        }
        th { color: var(--muted); font-weight: 600; }
        tbody tr:hover { background: rgba(255, 255, 255, 0.02); }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
            font-size: 12px;
        }
        .pill.dot::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent);
        }
        form {
            display: grid;
            gap: 10px;
        }
        label { font-size: 13px; color: var(--muted); font-weight: 600; letter-spacing: 0.01em; }
        input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid var(--card-border);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text);
            font-size: 15px;
            outline: none;
            transition: border 120ms ease, box-shadow 120ms ease;
        }
        input:focus {
            border-color: rgba(94, 240, 195, 0.5);
            box-shadow: 0 0 0 3px rgba(94, 240, 195, 0.12);
        }
        .grid-two { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
        .chip-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .code {
            font-family: 'Manrope', monospace;
            font-size: 13px;
            background: rgba(15, 23, 42, 0.5);
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid var(--card-border);
        }
        .response-box {
            min-height: 80px;
            background: rgba(15, 23, 42, 0.65);
            border: 1px dashed rgba(94, 240, 195, 0.35);
            border-radius: 14px;
            padding: 12px 12px 6px;
            font-family: 'Manrope', monospace;
            white-space: pre-wrap;
            color: var(--text);
            overflow: auto;
        }
        .status { font-weight: 700; color: var(--accent); }
        .subtext { color: var(--muted); font-size: 13px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .ghost-btn {
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: transparent;
            color: var(--text);
            cursor: pointer;
        }
        .ghost-btn:hover { border-color: rgba(94, 240, 195, 0.5); color: var(--accent); }
        small { color: var(--muted); }
    </style>
</head>
<body>
    <div class="page">
        <section class="hero">
            <div class="badge"><span></span> Laravel · In-memory City API</div>
            <h1>City API Explorer</h1>
            <p class="lead">Crafted for fast iteration: no database, just an in-memory store. Create, list, and delete cities instantly with live responses below.</p>
            <div class="cta-row">
                <button class="btn" id="loadCities">Load cities</button>
                <button class="btn secondary" id="scrollToForm">Add a city</button>
                <button class="btn secondary" id="scrollToDelete">Delete a city</button>
            </div>
            <div class="row">
                <div class="card">
                    <h3>Runtime</h3>
                    <div class="stat-number">Ephemeral</div>
                    <div class="stat-note">Data resets on each reboot</div>
                </div>
                <div class="card">
                    <h3>Endpoints</h3>
                    <div class="stat-number">/api/cities</div>
                    <div class="stat-note">GET, POST, DELETE</div>
                </div>
                <div class="card">
                    <h3>Format</h3>
                    <div class="stat-number">JSON</div>
                    <div class="stat-note">Ready for REST clients</div>
                </div>
            </div>
            <div class="card">
                <h3>Quick endpoints</h3>
                <div class="endpoint-list">
                    <div class="endpoint">
                        <div class="verb">GET</div>
                        <div class="path">/api/cities</div>
                        <div class="note">List all cities</div>
                    </div>
                    <div class="endpoint">
                        <div class="verb">POST</div>
                        <div class="path">/api/cities</div>
                        <div class="note">Create a city (JSON)</div>
                    </div>
                    <div class="endpoint">
                        <div class="verb" style="color: var(--accent-2); background: rgba(243, 139, 160, 0.18);">DELETE</div>
                        <div class="path">/api/cities/{id}</div>
                        <div class="note">Remove a city</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h2>Live data</h2>
                <div class="actions">
                    <button class="ghost-btn" id="refreshBtn">Refresh</button>
                    <button class="ghost-btn" id="clearLog">Clear log</button>
                    <button class="ghost-btn" id="runDemo">Run demo</button>
                </div>
            </div>
            <div class="chip-row" style="margin-bottom: 10px;">
                <div class="pill dot" id="statusPill">Waiting for first call</div>
                <div class="pill">Base URL: <span class="code" id="baseUrl"></span></div>
                <div class="pill">Store: in-memory</div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th style="width: 120px;">Population</th>
                            <th style="width: 120px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cityTableBody">
                        <tr><td colspan="5" class="subtext">No data yet. Load cities to begin.</td></tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 16px;">
                <div class="subtext" style="margin-bottom: 6px;">Response preview</div>
                <div class="response-box" id="responseBox">Awaiting response...</div>
            </div>
        </section>

        <section class="panel" id="formPanel">
            <div class="panel-header">
                <h2>Create a city</h2>
                <small>Fields: name (required), country (required), population (optional number).</small>
            </div>
            <form id="cityForm">
                <div class="grid-two">
                    <div>
                        <label for="name">City name</label>
                        <input id="name" name="name" placeholder="e.g., Cascadia" required>
                    </div>
                    <div>
                        <label for="country">Country</label>
                        <input id="country" name="country" placeholder="e.g., Utopia" required>
                    </div>
                </div>
                <div>
                    <label for="population">Population (number)</label>
                    <input id="population" name="population" type="number" min="0" step="1" placeholder="e.g., 1200000">
                </div>
                <div class="actions" style="margin-top: 4px;">
                    <button type="submit" class="btn" id="submitBtn">Save city</button>
                    <button type="button" class="btn secondary" id="resetBtn">Reset</button>
                </div>
            </form>
            <div style="margin-top: 14px;" class="subtext">Tip: Because storage is in-memory, restarting the app clears all cities.</div>
        </section>

        <section class="panel" id="deletePanel">
            <div class="panel-header">
                <h2>Delete a city</h2>
                <small>Provide a valid city ID to delete.</small>
            </div>
            <form id="deleteForm">
                <div class="grid-two">
                    <div>
                        <label for="deleteId">City ID</label>
                        <input id="deleteId" name="deleteId" type="number" min="1" placeholder="e.g., 1" required>
                    </div>
                </div>
                <div class="actions" style="margin-top: 4px;">
                    <button type="submit" class="btn" id="deleteBtn">Delete city</button>
                    <button type="button" class="btn secondary" id="deleteResetBtn">Reset</button>
                </div>
            </form>
            <div style="margin-top: 14px;" class="subtext">Note: You can also delete directly from the table above.</div>
        </section>
    </div>

    <script>
        const cityTableBody = document.getElementById('cityTableBody');
        const responseBox = document.getElementById('responseBox');
        const statusPill = document.getElementById('statusPill');
        const baseUrlEl = document.getElementById('baseUrl');
        const loadBtn = document.getElementById('loadCities');
        const refreshBtn = document.getElementById('refreshBtn');
        const clearLogBtn = document.getElementById('clearLog');
        const runDemoBtn = document.getElementById('runDemo');
        const formPanel = document.getElementById('formPanel');
        const scrollToFormBtn = document.getElementById('scrollToForm');
        const submitBtn = document.getElementById('submitBtn');
        const deletePanel = document.getElementById('deletePanel');
        const scrollToDeleteBtn = document.getElementById('scrollToDelete');
        const deleteForm = document.getElementById('deleteForm');
        const deleteIdInput = document.getElementById('deleteId');
        const deleteBtn = document.getElementById('deleteBtn');
        const deleteResetBtn = document.getElementById('deleteResetBtn');
        const resetBtn = document.getElementById('resetBtn');
        const form = document.getElementById('cityForm');
        const base = window.location.origin.replace(/\/$/, '') + '/api/cities';
        baseUrlEl.textContent = base;

        const setStatus = (text, good = true) => {
            statusPill.textContent = text;
            statusPill.style.color = good ? 'var(--accent)' : 'var(--accent-2)';
            statusPill.style.background = good ? 'rgba(94, 240, 195, 0.14)' : 'rgba(243, 139, 160, 0.14)';
        };

        const unwrap = (payload) => (payload && typeof payload === 'object' && 'data' in payload ? payload.data : payload);

        const setResponse = (status, body) => {
            const pretty = typeof body === 'string' ? body : JSON.stringify(body, null, 2);
            responseBox.textContent = `${status}\n\n${pretty}`;
        };

        const renderRows = (cities) => {
            if (!cities.length) {
                cityTableBody.innerHTML = '<tr><td colspan="5" class="subtext">No cities yet. Create one below.</td></tr>';
                return;
            }
            cityTableBody.innerHTML = cities.map(city => `
                <tr>
                    <td>${city.id}</td>
                    <td>${city.name}</td>
                    <td>${city.country}</td>
                    <td>${city.population ?? '—'}</td>
                    <td style="text-align: right;">
                        <button class="ghost-btn" data-id="${city.id}" data-action="delete">Delete</button>
                    </td>
                </tr>
            `).join('');
        };

        const handleError = async (res) => {
            let message = 'Request failed';
            try {
                const data = await res.json();
                message = JSON.stringify(data, null, 2);
            } catch (e) {
                message = await res.text();
            }
            setStatus(`Error ${res.status}`, false);
            setResponse(`HTTP ${res.status}`, message || 'No response');
        };

        const fetchCities = async () => {
            setStatus('Loading cities...');
            loadBtn.disabled = true;
            refreshBtn.disabled = true;
            try {
                const res = await fetch(base);
                if (!res.ok) return handleError(res);
                const payload = await res.json();
                const data = unwrap(payload);
                renderRows(Array.isArray(data) ? data : []);
                setStatus('Loaded');
                setResponse(`HTTP ${res.status}`, payload);
            } catch (err) {
                setStatus('Network error', false);
                setResponse('Error', err.message);
            } finally {
                loadBtn.disabled = false;
                refreshBtn.disabled = false;
            }
        };

        const createCity = async (payload) => {
            submitBtn.disabled = true;
            setStatus('Creating city...');
            try {
                const res = await fetch(base, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                if (!res.ok) return handleError(res);
                const createdPayload = await res.json();
                setStatus('City created');
                setResponse(`HTTP ${res.status}`, createdPayload);
                await fetchCities();
                form.reset();
            } catch (err) {
                setStatus('Network error', false);
                setResponse('Error', err.message);
            } finally {
                submitBtn.disabled = false;
            }
        };

        const deleteCity = async (id) => {
            setStatus(`Deleting #${id}...`);
            try {
                const res = await fetch(`${base}/${id}`, { method: 'DELETE', headers: { 'Accept': 'application/json' } });
                if (!res.ok) return handleError(res);
                setStatus('Deleted');
                if (res.status === 204) {
                    setResponse(`HTTP ${res.status}`, '');
                } else {
                    const payload = await res.json();
                    setResponse(`HTTP ${res.status}`, payload);
                }
                await fetchCities();
            } catch (err) {
                setStatus('Network error', false);
                setResponse('Error', err.message);
            }
        };

        const runDemo = async () => {
            runDemoBtn.disabled = true;
            setStatus('Running demo...');
            try {
                const demoPayload = {
                    name: `Demo City ${Math.floor(Math.random() * 1000)}`,
                    country: 'DemoLand',
                    population: Math.floor(Math.random() * 5_000_000),
                };

                const createRes = await fetch(base, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(demoPayload)
                });
                if (!createRes.ok) return handleError(createRes);
                const createPayload = await createRes.json();
                const created = unwrap(createPayload);
                setResponse(`HTTP ${createRes.status}`, { created });

                await fetchCities();
                await deleteCity(created.id);
                setStatus('Demo complete');
            } catch (err) {
                setStatus('Network error', false);
                setResponse('Error', err.message);
            } finally {
                runDemoBtn.disabled = false;
            }
        };

        cityTableBody.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-action="delete"]');
            if (!btn) return;
            const id = btn.getAttribute('data-id');
            deleteCity(id);
        });

        loadBtn.addEventListener('click', fetchCities);
        refreshBtn.addEventListener('click', fetchCities);
        clearLogBtn.addEventListener('click', () => setResponse('HTTP 200', 'Cleared. Ready for next call.'));
        runDemoBtn.addEventListener('click', runDemo);
        scrollToFormBtn.addEventListener('click', () => formPanel.scrollIntoView({ behavior: 'smooth' }));
        scrollToDeleteBtn.addEventListener('click', () => deletePanel.scrollIntoView({ behavior: 'smooth' }));
        resetBtn.addEventListener('click', () => form.reset());
        deleteResetBtn.addEventListener('click', () => deleteForm.reset());

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const payload = {
                name: form.name.value.trim(),
                country: form.country.value.trim(),
                population: form.population.value ? Number(form.population.value) : null,
            };
            if (!payload.name || !payload.country) {
                setStatus('Name and country are required', false);
                return;
            }
            createCity(payload);
        });

        // Auto-load on first visit
        fetchCities();

        // Inline delete form handling
        deleteForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const idVal = deleteIdInput.value.trim();
            if (!idVal) {
                setStatus('City ID is required', false);
                return;
            }
            deleteBtn.disabled = true;
            await deleteCity(Number(idVal));
            deleteBtn.disabled = false;
            deleteForm.reset();
        });
    </script>
</body>
</html>
