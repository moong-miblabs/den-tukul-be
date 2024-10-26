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

let allias = 'jj'

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

export default Jenjang