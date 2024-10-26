import { DataTypes } from 'sequelize';
import sq from '../../database.js'

let columns = {
	id: {
		type: DataTypes.SMALLINT,
		primaryKey: true
	},
	nama_penghasilan: {
		type: DataTypes.STRING
	}
}

let allias = 'ph'

const Penghasilan = sq.define('ref_penghasilan',
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

export default Penghasilan