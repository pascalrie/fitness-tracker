import {useEffect, useState} from "react";
import axios from "axios";
import NestedJsonViewer from "./RenderObjectsOrArrays";
import {useNavigate} from "react-router-dom";

const PlanListForm = () => {
    const [plans, setPlans] = useState([]);
    const [payload, setPayload] = useState([]);

    let navigate = useNavigate();
    const routeChange = () => {
        let path = "/create/plan";
        navigate(path);
    }
    useEffect(() => {
        const fetchPlans = async () => {
            try {
                const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/plan/list");
                const data = response.data;
                setPayload(data.exercises)
                if (Array.isArray(data)) {
                    setPlans(data);
                } else if (typeof data === "object") {
                    const plansArray = Object.values(data).filter((plans) => typeof plans === "object");
                    setPlans(plansArray);
                } else {
                    console.error("Unexpected data format for plans.", data);
                }
            } catch (error) {
                console.error("Error fetching Plans: ", error);
                setPlans([]);
            }
        }
        fetchPlans();
    }, []);
    return (
        <div className="p-4">
            <h2 className="text-xl font-bold mb-4">My Plans</h2>
            {plans.length === 0 ? (
                <p>No plans found.</p>
            ) : (
                <ul className="space-y-3">
                    {plans.map((plan) => (
                        <li
                            key={plan.id}
                            className="border rounded-xl p-3 shadow-sm hover:bg-gray-50"
                        >
                            <h3 className="font-semibold">{plan.startDate}</h3>
                            <p>Total days of training: {plan.totalDaysOfTraining}</p>
                            <div>
                                <NestedJsonViewer data={payload} title="Exercise"/>
                            </div>
                            <p>Split: {plan.split}</p>
                            <p>Training times a week: {plan.trainingTimesAWeek}</p>
                            <p>Active: {plan.active.toString()}</p>
                        </li>
                    ))}
                </ul>
            )}
            <button color="primary" className="px-4" onClick={routeChange}>Create Plan</button>
        </div>
    );
}

export default PlanListForm;