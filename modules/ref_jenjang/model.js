import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
    id: {
        type: DataTypes.SMALLINT,
        primaryKey: true
    },
    nama_jenjang: {
        type: DataTypes.STRING
    }
}

const Jenjang = sq.define('ref_jenjang',
    columns,
    {
        freezeTableName: true,
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: 'updated_at',
        paranoid: true,
        deletedAt: 'deleted_at',
    }
)

Jenjang.allias = 'jj'

Jenjang.$columns = (whitelist=[]) => {
    let arr = Object.keys(columns)
    /*===*/ arr.push('created_at'); arr.push('updated_at');
    if(whitelist.length) {
        arr = arr.filter(value => whitelist.includes(value))
    }
    return arr.map(str => `${Jenjang.allias}.${str}`).join(',');
}

Jenjang.$colAllias = (whitelist=[]) => {
    let arr = Object.keys(columns)
    /*===*/ arr.push('created_at'); arr.push('updated_at');
    if(whitelist.length) {
        arr = arr.filter(value => whitelist.includes(value))
    }
    return arr.map(str => `${Jenjang.allias}.${str} AS ${Jenjang.allias}__${str}`).join(',');
}

export default Jenjang