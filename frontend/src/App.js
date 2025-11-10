import ExecutionCreateForm from "./components/ExecutionCreateForm";
import React from 'react';
// import './styles/App.css';
import MenuBar from "./components/MenuBar";
import {BrowserRouter as Router, Routes, Route} from "react-router-dom";
import AboutPage from "./pages/AboutPage";
import ContactPage from "./pages/ContactPage";
import HomePage from "./pages/HomePage";

function App() {
  return (
    <div className="App">
        <Router>
            <MenuBar/>
            <Routes>
                <Route path="/create/execution" element={<ExecutionCreateForm/>}/>
                <Route path="/about" element={<AboutPage/>}/>
                <Route path="/contact" element={<ContactPage/>}/>
                <Route path="/home" element={<HomePage/>}/>
                <Route path="/" element={<HomePage/>}/>
            </Routes>
        </Router>
    </div>
  );
}

export default App;
/*
 <Route path="/workouts" element={<WorkoutListForm/>}/>
                <Route path="/exercises" element={<ExerciseListForm/>}/>
                <Route path="/executions" element={<ExecutionListForm/>}/>
                <Route path="/show/execution/:id" element={<ExecutionShowForm/>}/>
                <Route path="/plan" element={<PlanListForm/>}/>
                <Route path="/muscle/group" element={<MuscleGroupListForm/>}/>
                <Route path="/body/measurement" element={<BodyMeasurementListForm/>}/>
 */