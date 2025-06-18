import { Link } from "@/ui"

export const config = {
	id: "custom_dynamic_fields:Toolbox-right",
}

const ToolboxContact = ({ data }) => {
	const links = data?.components || []

	return (
		<div className="fixed right-0 top-1/2 z-40 hidden -translate-y-1/2 transform lg:block">
			<div className="flex flex-col overflow-hidden rounded-lg shadow-lg">
				{links.map((item, index) => (
					<Link
						key={index}
						href={item.link?.url || "#"}
						className="flex h-14 w-[220px] items-center justify-center bg-white text-center text-sm font-semibold text-[#0178F6] transition-all duration-200 hover:bg-[#0178F6] hover:text-white"
					>
						{item.link?.title || ""}
					</Link>
				))}
			</div>
		</div>
	)
}

export default ToolboxContact
