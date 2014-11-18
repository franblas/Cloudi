package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.GridLayout;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextField;

/**
 * 
 * @author Paco
 *
 */
public class OptionFrame extends JFrame implements MouseListener{

	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan4 = new JPanel();
	
	/**
	 * Les boutons
	 */
	private JButton bouton_bdd_appli = new JButton(); //bouton launch bdd appli request
	private JButton bouton_iconeappli = new JButton(); //bouton 
	private JButton bouton_slideappli1= new JButton(); //bouton 
	private JButton bouton_slideappli2 = new JButton(); //bouton 
	private JButton bouton_slideappli3 = new JButton(); //bouton 
	private JButton bouton_slideappli4 = new JButton(); //bouton 
	private JButton bouton_slideappli5 = new JButton(); //bouton 
	
	/**
	 * Les Labels
	 */
	private JLabel label_bdd_appli = new JLabel("BDD Application");
	private JLabel label_bdd_appli_cale = new JLabel("");
	private JLabel label_bdd_appli_cale2 = new JLabel("");
	private JLabel label_bdd_appli_name = new JLabel("Nom Application");
	private JLabel label_bdd_appli_nomcom = new JLabel("Nom Commande");
	private JLabel label_bdd_appli_lienweb = new JLabel("Lien Web");
	private JLabel label_bdd_appli_categorie = new JLabel("Categorie");
	private JLabel label_bdd_appli_description = new JLabel("Description");
	private JLabel label_bdd_appli_developer = new JLabel("Developer");
	private JLabel label_bdd_appli_version = new JLabel("Version");
	private JLabel label_iconeappli = new JLabel("Icone Application");
	private JLabel label_slideappli1 = new JLabel("Image 1 slide Application");
	private JLabel label_slideappli2 = new JLabel("Image 2 slide Application");
	private JLabel label_slideappli3 = new JLabel("Image 3 slide Application");
	private JLabel label_slideappli4 = new JLabel("Image 4 slide Application");
	private JLabel label_slideappli5 = new JLabel("Image 5 slide Application");
	
	/**
	 * les champs texte
	 */
	private JTextField text_bdd_appli_name = new JTextField();
	private JTextField text_bdd_appli_nomcom = new JTextField();
	private JTextField text_bdd_appli_lienweb = new JTextField();
	private JTextField text_bdd_appli_categorie = new JTextField();
	private JTextField text_bdd_appli_description = new JTextField();
	private JTextField text_bdd_appli_developer = new JTextField();
	private JTextField text_bdd_appli_version = new JTextField();
	
	public OptionFrame(String nom,int largeur, int hauteur){
		
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
		
		//boutons configuration
		bouton_bdd_appli.setToolTipText("Add application"); //Message au passage du curseur
		bouton_bdd_appli.setText("Application"); //Titre du bouton
		bouton_iconeappli.setText("Icone Application");
		bouton_iconeappli.setToolTipText("Selectionner une image pour l'application");
		bouton_slideappli1.setText("Slide Application");
		bouton_slideappli1.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli2.setText("Slide Application");
		bouton_slideappli2.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli3.setText("Slide Application");
		bouton_slideappli3.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli4.setText("Slide Application");
		bouton_slideappli4.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli5.setText("Slide Application");
		bouton_slideappli5.setToolTipText("Selectionner une image pour le slide de l'application");
		
		bouton_bdd_appli.addMouseListener(this);
		bouton_iconeappli.addMouseListener(this);
		bouton_slideappli1.addMouseListener(this);
		bouton_slideappli2.addMouseListener(this);
		bouton_slideappli3.addMouseListener(this);
		bouton_slideappli4.addMouseListener(this);
		bouton_slideappli5.addMouseListener(this);
		
		//layout configuration
		GridLayout gridpan1 = new GridLayout(0,1);
		GridLayout gridpan2 = new GridLayout(0,2);
		pan.setLayout(gridpan1);
		pan4.setLayout(gridpan2);
		
		//add components to panels
		pan4.add(label_bdd_appli);
		pan4.add(label_bdd_appli_cale);
		pan4.add(label_bdd_appli_name);
		pan4.add(text_bdd_appli_name);
		pan4.add(label_bdd_appli_nomcom);
		pan4.add(text_bdd_appli_nomcom);
		pan4.add(label_bdd_appli_lienweb);
		pan4.add(text_bdd_appli_lienweb);
		pan4.add(label_bdd_appli_categorie);
		pan4.add(text_bdd_appli_categorie);
		pan4.add(label_bdd_appli_description);
		pan4.add(text_bdd_appli_description);
		pan4.add(label_bdd_appli_developer);
		pan4.add(text_bdd_appli_developer);
		pan4.add(label_bdd_appli_version);
		pan4.add(text_bdd_appli_version);
		pan4.add(label_iconeappli);
		pan4.add(bouton_iconeappli);
		pan4.add(label_slideappli1);
		pan4.add(bouton_slideappli1);
		pan4.add(label_slideappli2);
		pan4.add(bouton_slideappli2);
		pan4.add(label_slideappli3);
		pan4.add(bouton_slideappli3);
		pan4.add(label_slideappli4);
		pan4.add(bouton_slideappli4);
		pan4.add(label_slideappli5);
		pan4.add(bouton_slideappli5);
		pan4.add(label_bdd_appli_cale2);
		pan4.add(bouton_bdd_appli);
		
		pan.add(pan4);
		
		this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);
		
		this.setVisible(true);
	}
	
	@Override
	public void mouseClicked(MouseEvent arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void mouseEntered(MouseEvent arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void mouseExited(MouseEvent arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void mousePressed(MouseEvent arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void mouseReleased(MouseEvent arg0) {
		// TODO Auto-generated method stub
		
	}


}//end of class
