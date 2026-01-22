const WorkoutListLatest = ({workout}) => {

    return (
        <div>
            <h2>My latest Workout</h2>
            {workout === null ? (
                <p>No workout found.</p>
                ): (
            <ul className="space-y-3">
                <li key={workout.id}>
                <h3>{workout.dateOfWorkout}, Stretch: {workout.stretch.toString()}, Body weight: {workout.bodyWeight.toString()} kg</h3>
                    {workout.executions !== [] ? (
                        <p>No executions in workout found.</p>
                    ) : (
                        <ul>
                            {workout.executions.map((execution) => (
                                <li key={execution.id}>
                                    <h3>{execution.createdAt}: {execution.exercise.uniqueName},
                                        {execution.repetitions}x {execution.weight} kg</h3>
                                </li>
                            ))
                            }
                        </ul>
                    )}
                </li>
            </ul>
            )}
        </div>
    );
}
export default WorkoutListLatest;
