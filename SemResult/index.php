<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>VIT Semester Result</title>
  <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f4f6f8; color: #333; }

    .header {
      background: #1a237e;
      color: white;
      padding: 14px 20px;
      text-align: center;
    }
    .header h1 { font-size: 22px; }
    .header p  { font-size: 13px; margin-top: 4px; opacity: 0.85; }

    .container { max-width: 960px; margin: 24px auto; padding: 0 16px; }

    .card {
      background: white;
      border: 1px solid #ddd;
      border-radius: 6px;
      padding: 20px;
      margin-bottom: 20px;
    }
    .card h2 { font-size: 17px; margin-bottom: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px; color: #1a237e; }

    .form-row { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 12px; }
    .form-group { display: flex; flex-direction: column; flex: 1; min-width: 180px; }
    .form-group label { font-size: 13px; margin-bottom: 4px; font-weight: bold; }
    .form-group input, .form-group select {
      padding: 8px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    .form-group input:focus, .form-group select:focus { outline: none; border-color: #1a237e; }

    .marks-section h3 { font-size: 15px; margin-bottom: 10px; color: #444; }
    .marks-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .marks-table th { background: #e8eaf6; padding: 9px 10px; text-align: left; border: 1px solid #ccc; }
    .marks-table td { padding: 8px 10px; border: 1px solid #ccc; }
    .marks-table input { width: 70px; padding: 5px; border: 1px solid #bbb; border-radius: 4px; font-size: 13px; }
    .marks-table input:focus { outline: none; border-color: #1a237e; }

    .btn {
      padding: 9px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      margin-right: 8px;
      margin-top: 12px;
    }
    .btn-primary { background: #1a237e; color: white; }
    .btn-primary:hover { background: #283593; }
    .btn-danger  { background: #c62828; color: white; font-size: 12px; padding: 5px 10px; margin: 0; }
    .btn-danger:hover  { background: #b71c1c; }
    .btn-info    { background: #0277bd; color: white; }
    .btn-info:hover    { background: #01579b; }

    /* Result Card */
    .result-card { background: #f9f9f9; border: 1px solid #ddd; border-radius: 6px; padding: 16px; margin-top: 16px; }
    .result-card h3 { font-size: 16px; color: #1a237e; margin-bottom: 12px; }
    .result-info { display: flex; flex-wrap: wrap; gap: 8px 24px; margin-bottom: 12px; font-size: 14px; }
    .result-info span b { color: #555; }

    .result-table { width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 8px; }
    .result-table th { background: #e8eaf6; padding: 8px 10px; border: 1px solid #ccc; text-align: left; }
    .result-table td { padding: 7px 10px; border: 1px solid #ccc; }

    .badge {
      display: inline-block;
      padding: 4px 14px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: bold;
    }
    .badge-pass { background: #c8e6c9; color: #1b5e20; }
    .badge-fail { background: #ffcdd2; color: #b71c1c; }

    .summary-box {
      margin-top: 12px;
      padding: 12px;
      border-radius: 5px;
      font-size: 14px;
    }
    .summary-pass { background: #e8f5e9; border: 1px solid #a5d6a7; }
    .summary-fail { background: #ffebee; border: 1px solid #ef9a9a; }

    /* Saved Results Table */
    .saved-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .saved-table th { background: #e8eaf6; padding: 9px; border: 1px solid #ccc; }
    .saved-table td { padding: 8px 9px; border: 1px solid #ccc; }
    .saved-table tr:nth-child(even) { background: #fafafa; }

    .msg { padding: 10px 14px; border-radius: 4px; font-size: 14px; margin-bottom: 14px; }
    .msg-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .msg-error   { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

    @media (max-width: 600px) {
      .form-group { min-width: 100%; }
      .marks-table input { width: 55px; }
    }
  </style>
</head>
<body>

<div id="root"></div>

<script type="text/babel">
const { useState, useEffect } = React;

const SUBJECTS = [
  "Data Structures",
  "Operating Systems",
  "Database Management",
  "Computer Networks"
];

// ─── Student Component (Child) ───────────────────────────────────────────────
function Student({ studentName, regNo, course, semester, marks, onMarkChange }) {
  return (
    <div className="card">
      <h2>Student Information</h2>
      <div className="result-info">
        <span><b>Name:</b> {studentName || "—"}</span>
        <span><b>Reg No:</b> {regNo || "—"}</span>
        <span><b>Course:</b> {course || "—"}</span>
        <span><b>Semester:</b> {semester || "—"}</span>
      </div>

      <div className="marks-section">
        <h3>Enter Marks</h3>
        <table className="marks-table">
          <thead>
            <tr>
              <th>Subject</th>
              <th>MSE Marks (Max 30)</th>
              <th>ESE Marks (Max 70)</th>
              <th>Total (100)</th>
            </tr>
          </thead>
          <tbody>
            {SUBJECTS.map((sub, i) => {
              const mse = marks[i]?.mse ?? "";
              const ese = marks[i]?.ese ?? "";
              const total = (parseFloat(mse) || 0) + (parseFloat(ese) || 0);
              return (
                <tr key={i}>
                  <td>{sub}</td>
                  <td>
                    <input
                      type="number" min="0" max="30"
                      value={mse}
                      onChange={e => onMarkChange(i, "mse", e.target.value)}
                      placeholder="0-30"
                    />
                  </td>
                  <td>
                    <input
                      type="number" min="0" max="70"
                      value={ese}
                      onChange={e => onMarkChange(i, "ese", e.target.value)}
                      placeholder="0-70"
                    />
                  </td>
                  <td>{mse !== "" || ese !== "" ? total : "—"}</td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>
    </div>
  );
}

// ─── Result Component (Child) ────────────────────────────────────────────────
function Result({ studentName, regNo, course, semester, marks }) {
  const computed = SUBJECTS.map((sub, i) => {
    const mse = parseFloat(marks[i]?.mse) || 0;
    const ese = parseFloat(marks[i]?.ese) || 0;
    const total = mse + ese;
    const passed = total >= 40 && ese >= 28; // min 40% total, 40% of ESE
    return { subject: sub, mse, ese, total, passed };
  });

  const allFilled = marks.every(m => m.mse !== "" && m.ese !== "");
  if (!allFilled || !studentName) return null;

  const totalMarks = computed.reduce((s, r) => s + r.total, 0);
  const percentage = (totalMarks / 400 * 100).toFixed(2);
  const overallPass = computed.every(r => r.passed);

  let grade = "";
  if (percentage >= 90) grade = "O";
  else if (percentage >= 80) grade = "A+";
  else if (percentage >= 70) grade = "A";
  else if (percentage >= 60) grade = "B+";
  else if (percentage >= 50) grade = "B";
  else grade = "F";

  return (
    <div className="result-card">
      <h3>Semester Result — {studentName} ({regNo})</h3>
      <div className="result-info">
        <span><b>Course:</b> {course}</span>
        <span><b>Semester:</b> {semester}</span>
      </div>

      <table className="result-table">
        <thead>
          <tr>
            <th>Subject</th>
            <th>MSE (30%)</th>
            <th>ESE (70%)</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          {computed.map((r, i) => (
            <tr key={i}>
              <td>{r.subject}</td>
              <td>{r.mse}</td>
              <td>{r.ese}</td>
              <td>{r.total}</td>
              <td>
                <span className={`badge ${r.passed ? "badge-pass" : "badge-fail"}`}>
                  {r.passed ? "PASS" : "FAIL"}
                </span>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      <div className={`summary-box ${overallPass ? "summary-pass" : "summary-fail"}`}>
        <strong>Total Marks:</strong> {totalMarks}/400 &nbsp;|&nbsp;
        <strong>Percentage:</strong> {percentage}% &nbsp;|&nbsp;
        <strong>Grade:</strong> {grade} &nbsp;|&nbsp;
        <strong>Result:</strong>{" "}
        <span className={`badge ${overallPass ? "badge-pass" : "badge-fail"}`}>
          {overallPass ? "PASS" : "FAIL"}
        </span>
      </div>
    </div>
  );
}

// ─── App Component (Parent) ──────────────────────────────────────────────────
function App() {
  // useState for form fields
  const [studentName, setStudentName] = useState("");
  const [regNo, setRegNo]             = useState("");
  const [course, setCourse]           = useState("B.Tech CSE");
  const [semester, setSemester]       = useState("Semester 1");

  // useState for marks — array of {mse, ese} per subject
  const [marks, setMarks] = useState(
    SUBJECTS.map(() => ({ mse: "", ese: "" }))
  );

  const [savedResults, setSavedResults] = useState([]);
  const [message, setMessage]           = useState(null);
  const [showSaved, setShowSaved]       = useState(false);

  function handleMarkChange(index, field, value) {
    setMarks(prev => {
      const updated = [...prev];
      updated[index] = { ...updated[index], [field]: value };
      return updated;
    });
  }

  function validateForm() {
    if (!studentName.trim()) return "Please enter student name.";
    if (!regNo.trim())       return "Please enter registration number.";
    for (let i = 0; i < marks.length; i++) {
      const mse = parseFloat(marks[i].mse);
      const ese = parseFloat(marks[i].ese);
      if (isNaN(mse) || mse < 0 || mse > 30) return `MSE marks for ${SUBJECTS[i]} must be 0–30.`;
      if (isNaN(ese) || ese < 0 || ese > 70) return `ESE marks for ${SUBJECTS[i]} must be 0–70.`;
    }
    return null;
  }

  function computeSummary() {
    const computed = marks.map(m => {
      const mse = parseFloat(m.mse) || 0;
      const ese = parseFloat(m.ese) || 0;
      const total = mse + ese;
      const passed = total >= 40 && ese >= 28;
      return { mse, ese, total, passed };
    });
    const totalMarks = computed.reduce((s, r) => s + r.total, 0);
    const percentage = parseFloat((totalMarks / 400 * 100).toFixed(2));
    const overallPass = computed.every(r => r.passed);
    return { totalMarks, percentage, status: overallPass ? "PASS" : "FAIL" };
  }

  function handleSave() {
    const err = validateForm();
    if (err) { setMessage({ type: "error", text: err }); return; }

    const { totalMarks, percentage, status } = computeSummary();

    const payload = {
      student_name: studentName,
      reg_no: regNo,
      course,
      semester,
      marks,
      total_marks: totalMarks,
      percentage,
      status
    };

    fetch("save_result.php?action=save", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          setMessage({ type: "success", text: data.message });
        } else {
          setMessage({ type: "error", text: data.message });
        }
      })
      .catch(() => setMessage({ type: "error", text: "Server error. Check PHP/MySQL." }));
  }

  function handleReset() {
    setStudentName("");
    setRegNo("");
    setCourse("B.Tech CSE");
    setSemester("Semester 1");
    setMarks(SUBJECTS.map(() => ({ mse: "", ese: "" })));
    setMessage(null);
  }

  function fetchSaved() {
    fetch("save_result.php?action=fetch")
      .then(r => r.json())
      .then(data => { setSavedResults(data); setShowSaved(true); })
      .catch(() => setMessage({ type: "error", text: "Could not fetch records." }));
  }

  function handleDelete(id) {
    if (!window.confirm("Delete this record?")) return;
    fetch(`save_result.php?action=delete&id=${id}`)
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          setSavedResults(prev => prev.filter(r => r.id !== id));
        }
      });
  }

  return (
    <div>
      <div className="header">
        <h1>VIT — Semester Result System</h1>
        <p>Vellore Institute of Technology | Academic Result Portal</p>
      </div>

      <div className="container">
        {message && (
          <div className={`msg ${message.type === "success" ? "msg-success" : "msg-error"}`}>
            {message.text}
          </div>
        )}

        {/* Student Details Form */}
        <div className="card">
          <h2>Student Details</h2>
          <div className="form-row">
            <div className="form-group">
              <label>Student Name</label>
              <input type="text" value={studentName}
                onChange={e => setStudentName(e.target.value)}
                placeholder="e.g. Ravi Kumar" />
            </div>
            <div className="form-group">
              <label>Registration No</label>
              <input type="text" value={regNo}
                onChange={e => setRegNo(e.target.value)}
                placeholder="e.g. 22BCE1234" />
            </div>
            <div className="form-group">
              <label>Course</label>
              <select value={course} onChange={e => setCourse(e.target.value)}>
                <option>B.Tech CSE</option>
                <option>B.Tech ECE</option>
                <option>B.Tech IT</option>
                <option>B.Tech Mech</option>
                <option>BCA</option>
                <option>MCA</option>
              </select>
            </div>
            <div className="form-group">
              <label>Semester</label>
              <select value={semester} onChange={e => setSemester(e.target.value)}>
                {[1,2,3,4,5,6,7,8].map(s => (
                  <option key={s}>Semester {s}</option>
                ))}
              </select>
            </div>
          </div>
        </div>

        {/* Student Component (Child) — receives props */}
        <Student
          studentName={studentName}
          regNo={regNo}
          course={course}
          semester={semester}
          marks={marks}
          onMarkChange={handleMarkChange}
        />

        {/* Result Component (Child) — receives props */}
        <Result
          studentName={studentName}
          regNo={regNo}
          course={course}
          semester={semester}
          marks={marks}
        />

        {/* Action Buttons */}
        <div>
          <button className="btn btn-primary" onClick={handleSave}>Save to Database</button>
          <button className="btn btn-info"    onClick={fetchSaved}>View All Results</button>
          <button className="btn" style={{background:"#eee",border:"1px solid #ccc"}} onClick={handleReset}>Reset</button>
        </div>

        {/* Saved Results */}
        {showSaved && (
          <div className="card" style={{marginTop:"20px"}}>
            <h2>All Saved Results</h2>
            {savedResults.length === 0 ? (
              <p style={{fontSize:"14px",color:"#777"}}>No records found.</p>
            ) : (
              <div style={{overflowX:"auto"}}>
                <table className="saved-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Reg No</th>
                      <th>Course</th>
                      <th>Semester</th>
                      <th>Total</th>
                      <th>%</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    {savedResults.map((r, i) => (
                      <tr key={r.id}>
                        <td>{i + 1}</td>
                        <td>{r.student_name}</td>
                        <td>{r.reg_no}</td>
                        <td>{r.course}</td>
                        <td>{r.semester}</td>
                        <td>{r.total_marks}/400</td>
                        <td>{r.percentage}%</td>
                        <td>
                          <span className={`badge ${r.status === "PASS" ? "badge-pass" : "badge-fail"}`}>
                            {r.status}
                          </span>
                        </td>
                        <td>
                          <button className="btn btn-danger" onClick={() => handleDelete(r.id)}>Delete</button>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>
        )}

        <p style={{fontSize:"12px",color:"#999",marginTop:"16px",textAlign:"center"}}>
          Pass Criteria: Minimum 40/100 per subject & minimum 28/70 in ESE.
          Grading: O≥90 | A+≥80 | A≥70 | B+≥60 | B≥50 | F&lt;50
        </p>
      </div>
    </div>
  );
}

ReactDOM.createRoot(document.getElementById("root")).render(<App />);
</script>
</body>
</html>
