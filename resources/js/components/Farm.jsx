import React, { useEffect, useMemo } from 'react';
import PropTypes from 'prop-types';
import useFarmService from '../hooks/services/useFarmService';
import useTurbineService from '../hooks/services/useTurbineService';
import { Link, useParams } from 'react-router-dom';
import useComponentService from '../hooks/services/useComponentService';


const Farm = () => {
    let { farmID } = useParams();

    const { farm, show: farmsShow, loading: farmsLoading, error: farmsError} = useFarmService();
    const { turbines, index: turbinesIndex, loading: turbinesLoading, error: turbinesError} = useTurbineService();
    const { components, index: componentsIndex, loading: componentsLoading, error: componentsError} = useComponentService();

    useEffect(() => {
        farmsShow(farmID);
        turbinesIndex(`farms/${farmID}/`);
        componentsIndex();
    }, [])

    const mergeData = () => {
        return turbines.map(turbine => {
            if (components.length === 0) {
                return {...turbine, components: null};
            }
            const turbineComponents = components.filter(component => component.turbine_id === turbine.id);
            return {...turbine, components: turbineComponents};
        });
    }

    const data = useMemo(() => mergeData(), [farm, turbines, components]);

    if(farmsLoading) return <p>Loading...</p>;
    if(farmsError) return <p>Error</p>;



    return (
        <div className="">
            <h1 className="text-2xl font-semibold text-gray-900 mb-4">{farm.name}</h1>

            <table className="min-w-full divide-y divide-gray-300">
                <thead className="bg-gray-50">
                <tr>
                    <th scope="col" className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                        Turbine Name
                    </th>
                    <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Component Count
                    </th>
                    <th scope="col" className="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span className="sr-only">View</span>
                    </th>
                </tr>
                </thead>
                <tbody className="divide-y divide-gray-200 bg-white">
                {data.map(turbine => (
                    <tr key={turbine.id}>
                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{turbine.name}</td>
                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{turbine.components !== null ? turbine.components.length : 'loading'}</td>
                        <td className="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <Link to={`/turbines/${turbine.id}`} className="text-indigo-600 hover:text-indigo-900">
                                View<span className="sr-only">, {turbine.name}</span>
                            </Link>
                        </td>
                    </tr>
                ))}

                </tbody>
            </table>
        </div>
    );
};

Farm.propTypes = {

};

export default Farm;
