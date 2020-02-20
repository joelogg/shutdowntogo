function mostrarGraficaDashBoard()
{

    c3.generate(
    {
        bindto: '#gauge_g1',
        data: 
        {
            columns: 
            [
                ['Finalizdo/Total', 67]
            ],
            type: 'gauge'
        },
        color: 
        {
            //pattern: ['#2222AA']
        }
    });
    

    c3.generate(
    {
        bindto: '#donut_g2',
        data: 
        {
            columns: 
            [
                [ 'Abiertas', 12 ],
                [ 'En progreso', 4 ],
                [ 'Finalizadas', 9 ],
                [ 'Atrazadas', 3 ],
                [ 'Reprogramadas', 7 ]
            ],
            type : 'donut',
        },
        donut: { title: '35 OT' },
    });


    c3.generate(
    {
        bindto: '#bar_g3',
        color: { pattern: [ '#FF5722', '#4CAF50' ] },
        data: 
        {
            columns: 
            [
                [ 'Abiertas', 118, 124, 332, 262, 182 ],
                [ 'En progreso', 118, 124, 332, 262, 182 ],
                [ 'Abiertas', 118, 124, 332, 262, 182 ],
                [ 'Finalizadas', 118, 124, 332, 262, 182 ],
                [ 'Reprogramadas', 138, 164, 474, 244, 216 ]
            ],
            type: 'bar',
            groups: 
            [
                ['data1','data2']
            ],
        },
        bar: 
        {
            width: { ratio: 0.5 },
        },
    });

    c3.generate(
    {
        bindto: '#bar_g4',
        color: { pattern: [ '#FF5722', '#4CAF50' ] },
        data: 
        {
            columns: 
            [
                [ 'data1', 492, 118, 124, 332, 262, 182 ],
                [ 'data2', 205, 138, 164, 474, 244, 216 ]
            ],
            type: 'bar',
        },
        bar: 
        {
            width: { ratio: 0.5 },
        },
    });

    
}