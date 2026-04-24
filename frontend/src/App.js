import ExecutionCreateForm from "./components/ExecutionCreateForm";
import React from 'react';
// import './styles/App.css';
import MenuBar from "./components/MenuBar";
import {BrowserRouter as Router, Routes, Route} from "react-router-dom";
import AboutPage from "./pages/AboutPage";
import ContactPage from "./pages/ContactPage";
import HomePage from "./pages/HomePage";
import PlanListForm from "./components/PlanListForm";
import PlanShowActiveForm from "./components/PlanShowActiveForm";
import ExecutionListForm from "./components/ExecutionListForm";
import PlanCreateForm from "./components/PlanCreateForm";
import ExerciseListForm from "./components/ExerciseListForm";
import ExerciseCreateForm from "./components/ExerciseCreateForm";
import WorkoutListForm from "./components/WorkoutListForm";
import BodyMeasurementListForm from "./components/BodyMeasurementListForm";
import BodyMeasurementCreateForm from "./components/BodyMeasurementCreateForm";
import WorkoutCreateForm from "./components/WorkoutCreateForm";

function App() {
  return (
    <div className="App">
        <Router>
            <MenuBar/>
            <Routes>
                <Route path="/create/execution" element={<ExecutionCreateForm/>}/>
                <Route path="/plan" element={<PlanListForm/>}/>
                <Route path="/show/active/plan" element={<PlanShowActiveForm/>}/>
                <Route path="/about" element={<AboutPage/>}/>
                <Route path="/contact" element={<ContactPage/>}/>
                <Route path="/home" element={<HomePage/>}/>
                <Route path="/" element={<HomePage/>}/>
                <Route path="/executions" element={<ExecutionListForm/>}/>
                <Route path="/create/plan" element={<PlanCreateForm/>}/>
                <Route path="/exercises" element={<ExerciseListForm/>}/>
                <Route path="/create/exercise" element={<ExerciseCreateForm/>}/>
                <Route path="/workouts" element={<WorkoutListForm/>}/>
                <Route path="/body/measurement" element={<BodyMeasurementListForm/>}/>
                <Route path="/create/workout" element={<WorkoutCreateForm/>}/>
                <Route path="/create/body/measurement/" element={<BodyMeasurementCreateForm/>}/>
            </Routes>
        </Router>
    </div>
  );
}

export default App;
/*
 <Route path="/workouts" element={<WorkoutListForm/>}/>
                <Route path="/show/execution/:id" element={<ExecutionShowForm/>}/>
                <Route path="/muscle/group" element={<MuscleGroupListForm/>}/>
 */