import React, { useEffect, useMemo } from 'react';
import PropTypes from 'prop-types';
import useInspectionService from '../hooks/services/useInspectionService';
import useTurbineService from '../hooks/services/useTurbineService';
import { Link } from 'react-router-dom';


const Inspections = props => {
    const { inspections, index: inspectionsIndex, loading: inspectionsLoading, error: inspectionsError} = useInspectionService();
    const { turbines, index: turbinesIndex, loading: turbinesLoading, error: turbinesError} = useTurbineService();

    useEffect(() => {
        inspectionsIndex();
        turbinesIndex();
    }, [])

    const mergeData = () => {
        return inspections.map(inspection => {
            if (turbines.length === 0) {
                return {...inspection, turbine: null};
            }
            const inspectionTurbine = turbines.find(turbine => turbine.id === inspection.turbine_id);
            return {...inspection, turbine: inspectionTurbine};
        });
    }

    const data = useMemo(() => mergeData(), [inspections, turbines]);

    if(inspectionsLoading) return <p>Loading...</p>;
    if(inspectionsError) return <p>Error</p>;



    return (
        <div className="">
            <h1 className="text-2xl font-semibold text-gray-900 mb-4">Inspections</h1>

            <table className="min-w-full divide-y divide-gray-300">
                <thead className="bg-gray-50">
                <tr>
                    <th scope="col" className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                        Inspection Date
                    </th>
                    <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Turbine
                    </th>
                    <th scope="col" className="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span className="sr-only">View</span>
                    </th>
                </tr>
                </thead>
                <tbody className="divide-y divide-gray-200 bg-white">
                {data.map(inspection => (
                    <tr key={inspection.id}>
                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{inspection.inspected_at}</td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{inspection.turbine !== null ? inspection.turbine.name : 'loading'}</td>
                        <td className="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <Link to={`/inspections/${inspection.id}`} className="text-indigo-600 hover:text-indigo-900">
                                View<span className="sr-only">, {inspection.name}</span>
                            </Link>
                        </td>
                    </tr>
                ))}

                </tbody>
            </table>
        </div>
    );
};

Inspections.propTypes = {

};

export default Inspections;
