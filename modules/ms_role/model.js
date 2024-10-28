import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
	id: {
		type: DataTypes.CHAR(21),
		primaryKey: true
	},
	nama_role: {
		type: DataTypes.STRING,
	},
	urut: {
		type: DataTypes.SMALLINT
	}
}

let allias = 'rl'

const Role = sq.define('ms_role',
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

export default Role